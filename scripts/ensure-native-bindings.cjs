#!/usr/bin/env node

const { execFileSync, execSync } = require('child_process');
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

function installPackage(packageName, version) {
  if (!version) {
    throw new Error(`Missing version for ${packageName}`);
  }
  log(`Installing ${packageName}@${version}...`);
  execSync(`npm install --no-save --force "${packageName}@${version}"`, {
    stdio: 'inherit',
    cwd: process.cwd(),
  });
}

function ensureRolldownLinuxBinding() {
  const rolldown = getPackageJson('rolldown');
  if (!rolldown) {
    return;
  }

  try {
    tryImportRolldown();
    log('Rolldown binding OK');
  } catch (error) {
    const version = rolldown.optionalDependencies && rolldown.optionalDependencies['@rolldown/binding-linux-x64-gnu'];
    installPackage('@rolldown/binding-linux-x64-gnu', version);
    tryImportRolldown();
    log('Rolldown binding repaired');
  }
}

function ensureLightningCssLinuxBinding() {
  const lightningcss = getPackageJson('lightningcss');
  if (!lightningcss) {
    return;
  }

  try {
    tryRequireLightningCss();
    log('Lightning CSS binding OK');
  } catch (error) {
    const version = lightningcss.optionalDependencies && lightningcss.optionalDependencies['lightningcss-linux-x64-gnu'];
    installPackage('lightningcss-linux-x64-gnu', version);
    tryRequireLightningCss();
    log('Lightning CSS binding repaired');
  }
}

function main() {
  if (process.platform !== 'linux') {
    log('Non-Linux platform detected, skipping native binding checks');
    return;
  }

  ensureRolldownLinuxBinding();
  ensureLightningCssLinuxBinding();
}

main();
