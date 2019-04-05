/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
        "jquery"
    ], function($){

        var widthOfParent = $(".productlabel-wrapper.category").parent().parent().width();
        var heightOfParent = $(".productlabel-wrapper.category").parent().parent().height() - 44;
        $(".productlabel-wrapper")[0].style.width = widthOfParent + "px";
        $(".productlabel-wrapper")[0].style.height = heightOfParent + "px";

        var widthOfParentProductView = $(".productlabel-wrapper.product").parent().width();
        var heightOfParentProductView = $(".productlabel-wrapper.product").parent().height() - 44;
        $(".productlabel-wrapper")[0].style.width = widthOfParentProductView + "px";
        $(".productlabel-wrapper")[0].style.height = heightOfParentProductView + "px";
    }
);