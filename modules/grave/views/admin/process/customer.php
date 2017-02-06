<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\assets\JqueryuiAsset;
use app\core\widgets\Area\Select;

JqueryuiAsset::register($this);

$this->title="购墓流程"
?>

<style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        border:none;
    }
  </style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        
        <div class="row">
            <div class="col-xs-12 address-index">
                    <div class="panel panel-info">
                    <div class="dHandler panel-heading">购买人信息 
                        <button type="button" class="delit close" style="display:none;">
                           <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                           <span class="sr-only">Close</span>
                        </button> 
                    </div>
				<div class="customer-form" style="width:90%;margin:auto;">

                    <?php $form = ActiveForm::begin(); ?>
                    <?php 
                        $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                     ?>

                    <table class="table table-condensed">
                        <tr>
                        <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-8 ui-widget">{input}{hint}{error}</div>'; ?>
                            <td><?= $form->field($tomb, 'agent_id')->dropDownList($agent,['id'=>'combobox'])->label('***(<font color="red">*</font>)') ?></td>
                            <td><?= $form->field($tomb, 'guide_id')->dropDownList($guide,['id'=>'guidbox'])->label("导购员(<font color='red'>*</font>)") ?></td>
                        </tr>
                        <?php 
                            $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                         ?>
                        <tr>

                            <td><?= $form->field($user, 'username')->textInput()->label("账号(<font color='red'>*</font>)") ?></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label("客户名(<font color='red'>*</font>)") ?></td>
                            <td><?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label("手机号(<font color='red'>*</font>)") ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'second_ct')->textInput(['maxlength' => true]) ?></td>
                            <td><?= $form->field($model, 'second_mobile')->textInput(['maxlength' => true]) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2">

                              <div class="form-group">
                                <label class="control-label col-sm-1" for="customer-addr"></label>
                                <div class="col-sm-10">
                                  <?= Select::widget([
                                    'pro_name' => 'Customer[province]',
                                    'city_name' => 'Customer[city]',
                                    'zone_name' => 'Customer[zone]',
                                    'pro'=>$model->province,
                                    'city'=>$model->city,
                                    'zone'=>$model->zone,
                                  ]);?>
                                </div>
                              </div>
                                <?php $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
                                      $form->fieldConfig['template']='{label}<div class="col-sm-10">{input}{hint}{error}</div>';
                                 ?>
                                <?= $form->field($model, 'addr')->textArea(['maxlength' => true, 'placeholder'=>'详细地址']) ?>
                            </td>
                        </tr>
                    </table>

                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-5" style="text-align:right;">
                            <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>

                </div>


                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('combobox') ?>  
$(function(){
    bootstrapButton   = $.fn.button.noConflict();  
    $.fn.bootstrapBtn = bootstrapButton;  

    cbox('combobox');
    cbox('guidbox');
})  


function cbox(id){
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox input-group" )
          .css('width','200px')
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left form-control" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .tooltip()
          .addClass('input-group-btn')
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });

    $('#'+id).combobox();
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['combobox'], \yii\web\View::POS_END); ?>  









	


	

				

