/*
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */

define([
    'jquery',
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function ($, _, uiRegistry, select) {
    'use strict';
    return select.extend({

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value)
        {
            // if (value !== 'undefined')
            // {
            console.log('toto2');
                var attribute = registry.get(this.parentName + '.' + 'attribute_id'),
                    option;

                if (attribute) {
                    option = attribute.indexedOptions[value];

                    this._super(value, field);

                    if (option === false) {
                        // hide select and corresponding text input field if region must not be shown for selected country
                        this.setVisible(false);

                        if (this.customEntry) {// eslint-disable-line max-depth
                            this.toggleInput(false);
                        }
                    }
                }
            // }
            return this._super();
        }
    });
});