<?php
Yii::import('zii.widgets.jui.CJuiAutoComplete');

class AutoComplete extends CJuiAutoComplete
{
    public $splitter = ',';
    public $multiple = false;

    /**
     * Run this widget.
     * This method registers necessary javascript and renders the needed HTML code.
     */
    public function run()
    {
        if ( !$this->multiple ) {
            return parent::run();
        }
        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }

        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        }

        if ($this->hasModel()) {
            echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textField($name, $this->value, $this->htmlOptions);
        }

        if ($this->sourceUrl !== null) {
            $this->source = 'function( request, response ) {$.getJSON( "' . CHtml::normalizeUrl($this->sourceUrl) . '", {
             term: extractLast( request.term )
            }, response );
			}';
        } else {
            $this->source = 'function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
					' . CJavaScript::encode($this->source) . ', extractLast( request.term ) ) );
			}';
        }

        if (isset($this->options['minLength'])) {
            $ml = $this->options['minLength'];
        } else {
            $ml = 2;
        }

        $options = CJavaScript::encode($this->options);

        $joiner = $this->splitter . ' ';
        $js     = 'jQuery(function($){
            function split( val ) {
                return val.split( /' . $this->splitter . '\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }
            $( "#' . $id . '" ).autocomplete({
                source: ' . $this->source . ',
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                search: function() {
                    // custom minLength
                    var term = extractLast( this.value );
                    if ( term.length < ' . $ml . ' ) {
                         return false;
                    }
               },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "' . $joiner . '" );
                    return false;
                }
            }); 
            $( "#' . $id . '" ).autocomplete("option",' . $options . ');
        })';
        Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id, $js);
    }
}
