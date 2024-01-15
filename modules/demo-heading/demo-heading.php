<?php
class TMDemoHeading extends FLBuilderModule {

    public function __construct() {
        parent::__construct(array(
        'name'            => __( 'Demo Heading', 'fl-builder' ),
        'description'     => __( 'Demo Heading', 'fl-builder' ),
        'group'           => __( 'Toolbox Modules', 'fl-builder' ),
        'category'        => __( 'Heading', 'fl-builder' ),
        'dir'             => TOOLBOXMODULES_DIR . '/modules/demo-heading/',
        'url'             => TOOLBOXMODULES_URL . '/modules/demo-heading/',
        'icon'            => 'button.svg',
        'editor_export'   => true, // Defaults to true and can be omitted.
        'enabled'         => true, // Defaults to true and can be omitted.
        'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

FLBuilder::register_module( 'TMDemoHeading', 
    array(
        'my-tab-1'      => array(
            'title'         => __( 'Tab 1', 'fl-builder' ),
            'sections'      => array(
                'my-section-1'  => array(
                    'title'         => __( 'Section 1', 'fl-builder' ),
                    'fields'        => array(
                        'heading_title'     => array(
                            'type'          => 'text',
                            'label'         => __( 'Heading Title', 'fl-builder' ),
                            'connections'   => array( 'string' ),
                        ),
                    )
                )
            )
        )
    ) 
);