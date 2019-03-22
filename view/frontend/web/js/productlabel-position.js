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

        var widthOfParent = $("#labels").parent().width();
        var heightOfParent = $("#labels").parent().height() - 44;
        $("#labels")[0].style.width = widthOfParent + "px";
        $("#labels")[0].style.height = heightOfParent + "px";
    }
);