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

## registering a twig namespace

When you're working with Twig/Timber you can load twig external files to use as includes/macros/blocks. In order to keep these files with your plugin, a view path to the `modules/` directory is registered so that it can find such files. There is also a namespace called '`toolboxmodules`' registered, which can be referenced as `@toolboxmodules` when you want to include a template:

    {% include '@toolboxmodules/demo-heading/includes/partial-snippet.twig' %}

for instance would be a twig template that sits in the same directory as `frontend.twig`.

If you want to register your own paths and namespaces, have a look in the `inc/Integration/Toolbox.php` file.

## adding a htmx registration

If any of the files in the plugin are to be used as ajax action hooks, you will need to tell Toolbox about it. You can use the following filter for this:

    add_filter( 'toolbox/htmx_dirs' , 'my_plugin_htmx_twigs' , 10 , 1 ) ;

    function my_plugin_htmx_twigs( $directories ) {

        return array_merge( $directories , [ TOOLBOXMODULES_DIR . 'modules' ] );
    }

This will search all twig templates found under the directory (and subdirectories ) to include any file that has the header `TemplateType : htmx` set and register it. Make sure to also have the `Action : {ACTIONNAME}` header set.