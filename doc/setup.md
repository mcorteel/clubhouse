# Setting up your clubhouse website

This documentation covers the bare minimum to get your website online.

## Prerequisites

* PHP >= 5.2
* Any version of MySQL (or MariaDB)
* An apache server

✅ This is very broad and ClubHouse should work with most PHP mutualized hosting platforms.

**⚠️ Markdown support depends on the [ParseDown](https://github.com/erusev/parsedown) library which only supports PHP version 5.3 and up. If you use an older version, you will only have plaintext support.**

## Creating the database and schema

Import the SQL migration files in order into your database.

**⚠️ ClubHouse doesn't support table prefixing for now, so ideally use an empty database!**

The `v1.sql` file contains a first user (login: `admin`, password: `password`). Don't forget to change this password right away!

Your website should now be up. Let's see what you can do to make it your own!

## Configuration

Log in using the top-right link. You will now see a user menu in its place. First go to your profile and change your password, then use the menu to go to the administration section.

ℹ️ The default user has the `super_admin` permission, meaning that there are no restrictions in what you can do.

From the administration section, you can configure most of your website's data and behavior.
