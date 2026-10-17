// Compiles the WordPress theme stylesheet: node wordpress/build.mjs
import { readFile, writeFile, mkdir } from 'node:fs/promises'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import postcss from 'postcss'
import tailwind from '@tailwindcss/postcss'

const root = resolve(dirname(fileURLToPath(import.meta.url)), 'sac-theme')
const from = resolve(root, 'src/theme.css')
const to = resolve(root, 'assets/css/theme.css')

const result = await postcss([tailwind({ base: root, optimize: { minify: true } })]).process(
  await readFile(from, 'utf8'),
  { from, to },
)
await mkdir(dirname(to), { recursive: true })
await writeFile(to, result.css)
console.log(`Built ${to} (${(result.css.length / 1024).toFixed(1)} KB)`)
