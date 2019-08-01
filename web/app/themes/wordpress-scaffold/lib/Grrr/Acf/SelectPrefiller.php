<?php namespace Grrr\Acf;

class SelectPrefiller {

    const ICONS = [
        'arrow' => 'Arrow',
        'cross' => 'Cross',
    ];

    public function register() {
        /*
        add_filter('acf/load_field/name=icon', [$this, 'adjust_icon_choices']);
        */
    }

    /**
     * Adjust select options for the field `icon`. Note that all fields called
     * `icon` will have their options prefilled, so it's wise to give this field
     * a pretty specific and non-clashing name.
     * See: https://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
     */
    public function adjust_icon_choices($field) {
        $field['choices'] = [];
        foreach (static::ICONS as $icon => $label) {
            $field['choices'][$icon] = $label;
        }
        return $field;
    }

}
