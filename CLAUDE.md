# JPKCom Theme is LiveCanvas friendly – Developer Reference

## Plugin Overview

Declares the two functions LiveCanvas looks for to treat the active theme as "LiveCanvas-friendly": `lc_theme_is_livecanvas_friendly()` (existence-only marker) and `lc_theme_bootstrap_version()` (returns the Bootstrap version, `5.3`). Both are guarded with `function_exists()` so a theme that already defines them does not trigger a redeclare fatal.

- **Text Domain:** `jpkcom-is-lc-friendly` (no header declared, defaults to slug; only used by the shared updater)
- **Requires Plugins:** `livecanvas`
- **Min PHP:** 8.3 | **Min WP:** 6.9
- **Network:** not network-only (no `Network:` header)

---

## Architecture

```
Main file (jpkcom-is-lc-friendly.php)
├── declare(strict_types=1)
├── Plugin header (Requires Plugins: livecanvas)
├── JPKCOM_IS_LC_FRIENDLY_VERSION constant
├── init @ priority 5: boot JPKComGitPluginUpdater
├── lc_theme_is_livecanvas_friendly() : void   (function_exists guarded; empty marker)
└── lc_theme_bootstrap_version() : float        (function_exists guarded; returns 5.3)
```

---

## Behaviour

| Function | Return | Purpose |
|----------|--------|---------|
| `lc_theme_is_livecanvas_friendly()` | `void` | Existence signals LiveCanvas the theme is supported |
| `lc_theme_bootstrap_version()` | `float` `5.3` | Tells LiveCanvas which Bootstrap version the theme targets |

These are LiveCanvas API-contract function names (not `jpkcom_`-prefixed) and must keep their names. Pair this with an `empty.php` page template in the theme (see README Installation).

---

## Constants

| Constant | Value | Purpose |
|----------|-------|---------|
| `JPKCOM_IS_LC_FRIENDLY_VERSION` | `'1.0.6'` | Plugin version (sync with header/README/phpdoc.xml) |

---

## File Structure

```
jpkcom-is-lc-friendly/
├── jpkcom-is-lc-friendly.php     ← Main: header, constant, LiveCanvas helpers, updater bootstrap
├── includes/
│   └── class-plugin-updater.php  ← GitHub auto-updater (namespace: JPKComIsLcFriendlyGitUpdate)
├── .github/workflows/release.yml ← Build ZIP, manifest, PHPDoc, deploy to gh-pages (on tag push)
├── phpdoc.xml                    ← phpDocumentor config
├── README.md                     ← Public readme (source for the WP plugin modal)
├── CLAUDE.md                     ← This file
├── LICENSE                       ← GPL-2.0-or-later
└── .gitignore
```

---

## Plugin Updater

- **Namespace:** `JPKComIsLcFriendlyGitUpdate\JPKComGitPluginUpdater`
- **Manifest URL:** `https://jpkcom.github.io/jpkcom-is-lc-friendly/plugin_jpkcom-is-lc-friendly.json`
- Shared JPKCom updater (downstream copy of upstream `jpkcom-post-filter`; do not edit per-plugin). SHA256 verification, `wp_safe_remote_get()`, URL validation, race-condition lock, 24 h cache, timing-safe `hash_equals()`. Checksum verification is **mandatory**: a missing or unfetchable `checksum_sha256` aborts the update instead of installing unverified code. The verified temp file is returned from `upgrader_pre_download`, so WordPress installs exactly the bytes that were hashed (no second download). Failed manifest fetches are negatively cached for 1 h.
- Hooks: `plugins_api`, `site_transient_update_plugins`, `upgrader_process_complete`, `upgrader_pre_download`.

---

## Release Workflow

**Supply-chain: GitHub Actions sind auf Commit-SHAs gepinnt.** Alle `uses:`-Zeilen in `.github/workflows/` referenzieren einen 40-stelligen Commit-SHA statt eines Tags (`@v4`), mit der Version als Kommentar dahinter. Grund: ein Tag ist ein beweglicher Zeiger und lässt sich umhängen, ein SHA nicht. Da dieser Workflow die Plugin-ZIP **und** die SHA256-Summe erzeugt, der der Auto-Updater vertraut, würde eine kompromittierte Action ein manipuliertes ZIP samt passender Prüfsumme ausliefern — die Prüfsumme sichert den Transportweg, das Pinning den Build. `.github/dependabot.yml` hält die Pins wöchentlich aktuell (ein gesammelter PR). Beim Aktualisieren immer SHA *und* Versionskommentar zusammen ändern.

**CI & Dependabot-Auto-Merge.** Zwei zusätzliche Workflows:

- `.github/workflows/ci.yml` — läuft auf jedem `pull_request`. Prüft: `php -l` über alle PHP-Dateien; ungültige benannte Argumente an internen PHP-Funktionen (fängt die Klasse `sprintf(format:, values:)` → `ArgumentCountError`, die `php -l` nicht sieht); YAML-Validität aller `.github`-Dateien; und dass jede Action auf einem 40-stelligen Commit-SHA gepinnt ist (beide YAML-Formen, `uses:` und `- uses:`).
- `.github/workflows/dependabot-auto-merge.yml` — merged Dependabot-PRs automatisch, aber nur `semver-patch` und `semver-minor`. Major-Updates bekommen stattdessen einen Kommentar und bleiben manuell. Greift nur bei PRs von `dependabot[bot]` aus diesem Repo, nie aus Forks.

> **Zwei Repo-Einstellungen sind Voraussetzung, sonst ist der Auto-Merge wirkungslos oder gefährlich:**
> 1. **„Allow auto-merge"** muss in den Repo-Settings aktiv sein.
> 2. Der Branch-Schutz muss den CI-Job als **Required status check** führen (`CI / Lint & Guards`). Fehlt das, merged `gh pr merge --auto` **sofort** — es gibt dann nichts, worauf es warten müsste, und die CI wäre reine Dekoration.

Zusammen mit `cooldown: default-days: 7` in der `dependabot.yml` heißt das: kein Action-Release wird in seiner ersten Woche übernommen, patch/minor laufen danach automatisch durch (sofern CI grün), major bleibt eine bewusste Entscheidung.


Triggered by **pushing a `v*` tag**; the workflow creates the GitHub release automatically. Pipeline: setup PHP/Python/Pandoc/GraphViz → README metadata → slug-named ZIP → SHA256 → upload ZIP + `.sha256` → `plugin_<slug>.json` manifest → PHPDoc → deploy to `gh-pages`.

---

## Security Checklist

- `declare(strict_types=1)` in every PHP file
- LiveCanvas helpers guarded with `function_exists()` (no redeclare fatal)
- Updater: SHA256 verification + URL validation (audited separately)

---

## Release Checklist

1. Bump version in: header `Version:` + `Stable tag:`, `JPKCOM_IS_LC_FRIENDLY_VERSION`, `README.md`, `phpdoc.xml`
2. Add a `### x.y.z` block to `## Changelog` in `README.md`
3. Commit, tag `vx.y.z`, push the tag → the workflow builds and publishes everything
