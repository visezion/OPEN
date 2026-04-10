#!/usr/bin/env node

const { execFileSync } = require('child_process');
const fs = require('fs');
const path = require('path');

function log(message) {
  process.stdout.write(`[native-bindings] ${message}\n`);
}

function runNode(args) {
  execFileSync(process.execPath, args, { stdio: 'ignore' });
}

function tryImportRolldown() {
  runNode(['--input-type=module', '-e', "import('rolldown')"]);
}

function tryRequireLightningCss() {
  runNode(['-e', "require('lightningcss')"]);
}

function getPackageJson(packageName) {
  const packageJsonPath = path.join(process.cwd(), 'node_modules', ...packageName.split('/'), 'package.json');
  if (!fs.existsSync(packageJsonPath)) {
    return null;
  }
  return JSON.parse(fs.readFileSync(packageJsonPath, 'utf8'));
}

function installPackages(packageSpecs) {
  if (!packageSpecs.length) {
    return;
  }

  const npmBin = process.platform === 'win32' ? 'npm.cmd' : 'npm';
  log(`Installing missing native packages: ${packageSpecs.join(', ')}`);
  execFileSync(npmBin, ['install', '--no-save', '--force', ...packageSpecs], {
    stdio: 'inherit',
    cwd: process.cwd(),
  });
}

function getLinuxBindingSpecs() {
  const specs = [];
  const rolldown = getPackageJson('rolldown');
  if (rolldown && rolldown.optionalDependencies && rolldown.optionalDependencies['@rolldown/binding-linux-x64-gnu']) {
    specs.push(`@rolldown/binding-linux-x64-gnu@${rolldown.optionalDependencies['@rolldown/binding-linux-x64-gnu']}`);
  }
  const lightningcss = getPackageJson('lightningcss');
  if (lightningcss && lightningcss.optionalDependencies && lightningcss.optionalDependencies['lightningcss-linux-x64-gnu']) {
    specs.push(`lightningcss-linux-x64-gnu@${lightningcss.optionalDependencies['lightningcss-linux-x64-gnu']}`);
  }
  return specs;
}

function verifyBindings() {
  const statuses = {
    rolldownOk: true,
    lightningCssOk: true,
  };

  if (getPackageJson('rolldown')) {
    try {
      tryImportRolldown();
      log('Rolldown binding OK');
    } catch (error) {
      statuses.rolldownOk = false;
      log('Rolldown binding check failed');
    }
  }

  if (getPackageJson('lightningcss')) {
    try {
      tryRequireLightningCss();
      log('Lightning CSS binding OK');
    } catch (error) {
      statuses.lightningCssOk = false;
      log('Lightning CSS binding check failed');
    }
  }

  return statuses;
}

function main() {
  if (process.platform !== 'linux') {
    log('Non-Linux platform detected, skipping native binding checks');
    return;
  }

  const firstPass = verifyBindings();
  if (firstPass.rolldownOk && firstPass.lightningCssOk) {
    return;
  }

  // Install all relevant Linux bindings in one transaction to avoid npm pruning
  // one repaired binding while installing another.
  const bindingSpecs = getLinuxBindingSpecs();
  installPackages(bindingSpecs);

  const secondPass = verifyBindings();
  if (!secondPass.rolldownOk || !secondPass.lightningCssOk) {
    throw new Error('Native binding verification failed after repair');
  }

  log('Native bindings repaired and verified');
}

main();
