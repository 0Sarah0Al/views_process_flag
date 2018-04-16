The purpose of this module is to provide the ability to highlight views' tables. A use case example, will be to mark/flag a row as processed/read in a table of node's articles or pages.

When you enable this module, you have to run update.php or 'drush updb' so that a base field is added to your node_field_data table.
You can add this field to as many entity types as you like by editing the function views_process_flag_entity_base_field_info() in the .module file.

After that go to your views' table and add a field called 'process flag' under the 'global' category.
You can now toggle the color of the highlighted rows.
See image. [here](https://github.com/Sarahphp1/views_process_flag/process_flag_example_views.png)



# License

A copy of the GNU General Public License is included (refer to LICENSE.txt).

# Requirements

The core views module is required for this module.

# Installation

Install module as per [standard procedure][drupal-module-install].

[drupal-module-install]: https://www.drupal.org/docs/8/extending-drupal/installing-contributed-modules "Installing Contributed Modules"

# Maintainers

Current maintainers:
* Sarah Al (Sarahphp1)


