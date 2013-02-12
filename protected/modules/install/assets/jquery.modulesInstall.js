/**
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
function modulesInstall(options) {
    this.defaults = {
        url     : '',
        modules : [],
        messages: {'Installation': 'Installation'}
    };
    var opts = $.extend({}, this.defaults, options);
    var countModules = opts.modules.length;
    var modulesInstalled = [];
    install(0);//start install first module
    function install(i) {
        var moduleAccordion = jQuery("#accordion" + opts.modules[i]);
        var moduleCollapse = jQuery("#collapse" + opts.modules[i]);
        $.ajax({
            url       : opts.url,
            data      : {'id': opts.modules[i]},
            dataType  : 'json',
            beforeSend: function() {
                moduleCollapse.children().html(opts.messages['Installation'] + '<span></span>');
                moduleCollapse.collapse('show');
            },
            success   : function(data/*, status*/) {
                modulesInstalled.push(opts.modules[i]);
                progressModuleInstalled();
                moduleAccordion.append('<i class="icon-' + (data.error ? 'remove' : 'ok') + '"></i>');
                moduleCollapse.children().html(data.response);
                jQuery("#collapse" + opts.modules[i - 1]).collapse('hide');
            },
            error     : function(data) {
                jQuery('#accordion' + opts.modules[i]).append('<i class="icon-remove"></i>');
                moduleCollapse.children().html(data.response);
            }
        }).done(function() {
                i++;
                if ( opts.modules.length > i ) {
                    install(i);//install next module
                } else {
                    jQuery('div.progress').hide('fast');
                    jQuery('#button-next').show('fast');
                    moduleCollapse.collapse('hide')
                }
            });
        return false;
    }

    function progressModuleInstalled() {
        jQuery('div.bar').css('width', (modulesInstalled.length * 100 / countModules) + '%');
    }
}