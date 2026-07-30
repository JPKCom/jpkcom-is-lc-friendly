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
| `JPKCOM_IS_LC_FRIENDLY_VERSION` | matches the header `Version:` | Plugin version (sync with header/README/phpdoc.xml) |

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

**Actions are pinned to commit SHAs.** Every `uses:` line in `.github/workflows/` references a 40-character commit SHA instead of a tag (`@v4`), with the version as a trailing comment. A tag is a movable pointer and can be repointed; a SHA cannot. Since the release workflow builds the plugin ZIP **and** the SHA256 checksum the auto-updater trusts, a compromised action would ship a tampered ZIP together with a matching checksum — the checksum secures the transport, the pinning secures the build. `.github/dependabot.yml` keeps the pins current weekly in one combined PR; when updating, always change the SHA *and* the version comment together.

**CI** (`.github/workflows/ci.yml`) runs on every pull request *and* on every push to `main` — a required status check only covers pull requests, so a direct push with bypass rights would otherwise skip the checks entirely. It runs `php -l` over all PHP files; flags invalid named arguments to internal PHP functions (catches `sprintf(format:, values:)` → `ArgumentCountError`, which `php -l` does not see); validates the YAML of every `.github` file; asserts every action is pinned to a 40-character commit SHA; and executes `tests/test-*.php` where present.

**Dependabot auto-merge** (`.github/workflows/dependabot-auto-merge.yml`) merges only `semver-patch` and `semver-minor`, and only PRs from `dependabot[bot]` in this repo — never from forks. Major updates get a comment and stay manual. Two repo settings are prerequisites, otherwise this is useless or outright dangerous: "Allow auto-merge" must be enabled, and branch protection must list `CI / Lint & Guards` as a **required status check** — without it `gh pr merge --auto` merges *immediately*, since there is nothing left to wait for. Together with `cooldown: default-days: 7` no action release is adopted during its first week.

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
