## adhocore/phint

Initializes new PHP project with sane defaults using templates.
It scaffolds PHP library &/or project to boost your productivity and save time.
It helps you be even more lazier! `phint` is work in progress and the plan is to make it [big](#todo).

[![Latest Version](https://img.shields.io/github/release/adhocore/phint.svg?style=flat-square)](https://github.com/adhocore/phint/releases)
[![Travis Build](https://img.shields.io/travis/adhocore/phint/master.svg?style=flat-square)](https://travis-ci.org/adhocore/phint?branch=master)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/adhocore/phint.svg?style=flat-square)](https://scrutinizer-ci.com/g/adhocore/phint/?branch=master)
[![Codecov branch](https://img.shields.io/codecov/c/github/adhocore/phint/master.svg?style=flat-square)](https://codecov.io/gh/adhocore/phint)
[![StyleCI](https://styleci.io/repos/108550679/shield)](https://styleci.io/repos/108550679)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

![Phint Preview](https://imgur.com/gkidPSz.png "Phint Preview")

## Installation

> Requires PHP7.

### Manual

Download `phint.phar` from [latest release](https://github.com/adhocore/phint/releases/latest).
And use it like so `php /path/to/phint.phar [opts] [args]`. Hmm not cool. See Command section below.

### Command

```bash
# get latest version (you need `jq`)
LATEST_PHINT=`curl --silent "https://api.github.com/repos/adhocore/phint/releases/latest" | jq -r .tag_name`

# download latest phint
curl -sSLo ~/phint.phar "https://github.com/adhocore/phint/releases/download/$LATEST_PHINT/phint.phar"

# make executable
chmod +x ~/phint.phar
sudo ln -s ~/phint.phar /usr/local/bin/phint

# check
phint --help
```

## Features:

- generate dot files the likes of `.gitignore, .travis.yml, . editorconfig` etc
- generate `LICENSE`, `README.md`, `composer.json`
- generate `CHANGELOG.md` stub, `CONTRIBUTING.md` guide, `ISSUE_TEMPLATE.md` and `PULL_REQUEST_TEMPLATE.md`
- generate binaries if any
- git init
- interactively ask and install all the dev and prod deps
- generate `phpunit.xml`, test `bootstrap.php`
- generate test stubs for all classes/methods corresponding to `src` (`phint test`)
- update its own self (`phint update`)


## Usage

It can be used to quickly spin off new  project containing all basic and default stuffs. The quick steps are as follows:

```bash
# See options/arguments
phint init --help

# OR (shortcut)
phint i -h

# Below command inits a brand new PHP project in `project-name` folder in current dir
# Missing arguments are interactively collected
phint init project-name

# You can also use config file (with json) to read option values from
phint init project-name --config phint.json
```

## Commands

### init

> alias i

Create and Scaffold a bare new PHP project.

***Parameters:***

Dont be intimidated by long list of parameters, you are not required to enter any of them
as arguments as they are interactively collected when required.
Also check [config](#exampleconfig) on how to create a reusable json config so you can use `phint` like a *pro*.

```
Arguments:
  <project>  The project name without slashes

Options:
  [-b|--bin...]            Executable binaries
  [-c|--no-codecov]        Disable codecov
  [-C|--config]            JSON filepath to read config from
  [-d|--descr]             Project description
  [-D|--dev...]            Developer packages
  [-e|--email]             Vendor email
  [-f|--force]             Run even if the project exists
  [-G|--gh-template]       Use `.github/` as template path
                           By default uses `docs/`
  [-h|--help]              Show help
  [-w|--keywords...]       Project Keywords
  [-L|--license]           License
  [-n|--name]              Vendor full name
  [-N|--namespace]         Root namespace (use `/` separator)
  [-g|--package]           Packagist name (Without vendor handle)
  [-p|--path]              The project path (Auto resolved)
  [-P|--php]               Minimum PHP version
  [-R|--req...]            Required packages
  [-s|--no-scrutinizer]    Disable scrutinizer
  [-l|--no-styleci]        Disable StyleCI
  [-S|--sync]              Only create missing files
                           Use with caution, take backup if needed
  [-t|--no-travis]         Disable travis
  [-T|--type]              Project type
  [-u|--username]          Vendor handle/username
  [-z|--using]             Reference package
  [-v|--verbosity]         Verbosity level
  [-V|--version]           Show version
  [-y|--year]              License Year

Usage Examples:
  phint init <project> --force --descr "Awesome project" --name "YourName" --email you@domain.com
  phint init <project> --using laravel/lumen --namespace Project/Api --type project</comment>
  phint init <project> --php 7.0 --config /path/to/json --dev mockery/mockery --req adhocore/cli
```

### Example config

Parameters sent via command args will have higher precedence than values from config file (`-C --config`).

What can you put in config? Anything but we suggest you put only known options (check `$ phint init --help`)

```json
{
  "type": "library",
  "namespace": "Ahc",
  "username": "adhocore",
  "name": "Jitendra Adhikari",
  "email": "jiten.adhikary@gmail.com",
  "php": "7.0",
  "codecov": false,
  "...": "..."
}
```

## update

> alias u

Update Phint to lastest version or rollback to earlier locally installed version.

***Parameters:***

```
Arguments:
  (n/a)

Options:
  [-h|--help]         Show help
  [-r|--rollback]     Rollback to earlier version
  [-v|--verbosity]    Verbosity level
  [-V|--version]      Show version

Legend: <required> [optional] variadic...

Usage Examples:
  phint update        Updates to latest version
  phint u             Also updates to latest version
  phint update -r     Rolls back to prev version
  phint u --rollback  Also rolls back to prev version
```

## test

> alias t

Generate test files with proper classes and test methods analogous to their source counterparts.

***Parameters:***

```
Arguments:
  (n/a)

Options:
  [-a|--with-abstract]    Create stub for abstract/interface class
  [-d|--dump-autoload]    Force composer dumpautoload (slow)
  [-h|--help]             Show help
  [-n|--naming]           Test method naming format [t: testMethod | m: test_method | i: it_tests_]
  [-p|--phpunit]          Base PHPUnit class to extend from
  [-s|--no-setup]         Dont add setup method
  [-t|--no-teardown]      Dont add teardown method
  [-v|--verbosity]        Verbosity level
  [-V|--version]          Show version

Usage Examples:
  phint test -n i        With `it_` naming
  phint t --no-teardown  Without `tearDown()`
  phint test -a          With stubs for abstract/interface
```


## Todo

Including but not limited to:

- [ ] Readme.md generator
- [x] Test files generator
- [ ] Specify template path (with fallback to current)
