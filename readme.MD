# Toolbox Beaver Builder Modules

This plugin adds a way to create modules and render the frontend.php and others using a Twig/Timber template.

In this plugn module files in the `/modules` directory will automatically be registered, as long as the main file matches the directory name. So correct starter modules are:

- `modules/demo-heading/demo-heading.php`
- `modules/my-custom-module/my-custom-module.php`

Modules are the same as any other Beaver Builder Module, but you can redirect the output to a Twig template. For that you add a `frontend.php` file to `/modules/module-name/includes/` directory and in that file you add the following code:

    <?php
    use ToolboxModules\Frontend;
    /**
    * Process the frontend of this module using Timber
    */
    Frontend::beaverbuilderFrontend( __FILE__ , '/frontend.twig',  $settings, $id, $module);

This will render the `/frontend.twig` in the same directory ( `modules/module-name/includes/frontend.twig` ) and pass the `$settings`, `$id` and `$module` as Twig variables `settings`, `id` and `module` for use in your Twig template.

You don't HAVE to use Twig/Timber, for anything here, but you can using the above. Check the demo heading module for usage.