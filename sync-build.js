import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const src = path.join(__dirname, 'public', 'build');
const dest = path.join(__dirname, 'build');

if (!fs.existsSync(src)) {
    process.exit(0);
}

if (fs.existsSync(dest)) {
    fs.rmSync(dest, { recursive: true, force: true });
}

fs.cpSync(src, dest, { recursive: true });
