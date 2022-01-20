<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Newsletter Editor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://grapesjs.com/stylesheets/grapes.min.css?v0.14.62">
    <link rel="stylesheet" href="<?=BASEURL;?>assets/administrator/newsletter_editor/style/material.css">
    <link rel="stylesheet" href="<?=BASEURL;?>assets/administrator/newsletter_editor/style/tooltip.css">
    <link rel="stylesheet" href="<?=BASEURL;?>assets/administrator/newsletter_editor/style/toastr.min.css">
    <link rel="stylesheet" href="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/grapesjs-preset-newsletter.css">
    <link rel="stylesheet" href="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/demos.css">
    <link rel="stylesheet" href="https://grapesjs.com/js/ckeditor/skins/moono-lisa/editor_gecko.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/aviary.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/ckeditor.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/grapesjs-plugin-ckeditor.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/grapes.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/grapesjs-preset-newsletter.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/aviary.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/toastr.min.js"></script>
    <script src="<?=BASEURL;?>assets/administrator/newsletter_editor/dist/ajaxable.min.js"></script>
    
  </head>
  <style>
    body, html{ height: 100%; margin: 0;}
    .nl-link {
      color: inherit;
    }
    .info-link {
      text-decoration: none;
    }
    #info-cont {
      line-height: 17px;
    }
    .grapesjs-logo {
      display: block;
      height: 90px;
      margin: 0 auto;
      width: 90px;
    }
    .grapesjs-logo path{
      stroke: #eee !important;
      stroke-width: 8 !important;
    }

    #toast-container {
      font-size: 13px;
      font-weight: lighter;
    }
    #toast-container > div,
    #toast-container > div:hover{
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
      font-family: Helvetica, sans-serif;
    }
    #toast-container > div{
      opacity: 0.95;
    }
	
	.fa-download, .fa-warning, .fa-question-circle {display:none;}
	form {padding:20px;}
	form input[type="submit"] {background:#09F; color:#fff; padding:5px 10px; border:0; cursor:pointer;}
	#popup_form {display:none;}
	#ppp {float:right; padding:6px 15px; background:#09F; text-decoration:none; color:#fff; margin:18px;
  }
  #popup_form {position:fixed; width:100%; max-width:500px; padding:50px 10px; top:25%; left:25%; background:#000; z-index:2000; text-align:center;}
  #popup_form span {right:-5px; top:-5px; color:#fff; position:absolute; background:#F00; padding:5px 10px 5px; cursor:pointer}
  #popup_form b {background:#F00; padding:5px 10px 5px; cursor:pointer; color:#fff;}
  
  #popup_form input[type="text"]{min-height:10px; min-width:200px; padding:5px 10px}
  </style>
  <body>


    <div id="gjs" style="height:0px; overflow:hidden; max-height:90%;">


      <table class="main-body">
  <tr class="row">
    <td class="main-body-cell">
      <table class="container">
        <tr>
          <td class="container-cell">
            <table class="table100 c1790">
              <tr>
                <td class="top-cell" id="c1793">
                  <u class="browser-link" id="c307">View in browser
                  </u>
                </td>
              </tr>
            </table>
            <table class="c1766">
              <tr>
                <td class="cell c1769">
                  <img class="c926" src="http://artf.github.io/grapesjs/img/grapesjs-logo.png" alt="GrapesJS."/>
                </td>
                
                <td class="cell c1776">
                  <div class="c1144">GrapesJS Newsletter Builder
                    <br/>
                  </div>
                </td>
              </tr>
            </table>
            <table class="card">
              <tr>
                <td class="card-cell">
                  <img class="c1271" src="http://artf.github.io/grapesjs/img/tmp-header-txt.jpg" alt="Big image here"/>
                  <table class="table100 c1357">
                    <tr>
                      <td class="card-content">
                        <h1 class="card-title">Build your newsletters faster than ever
                          <br/>
                        </h1>
                        <p class="card-text">Import, build, test and export responsive newsletter templates faster than ever using the GrapesJS Newsletter Builder.
                        </p>
                        <table class="c1542">
                          <tr>
                            <td class="card-footer" id="c1545">
                              <a class="button" href="https://github.com/artf/grapesjs">Free and Open Source
                              </a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table class="list-item">
              <tr>
                <td class="list-item-cell">
                  <table class="list-item-content">
                    <tr class="list-item-row">
                      <td class="list-cell-left">
                        <img class="list-item-image" src="http://artf.github.io/grapesjs/img/tmp-blocks.jpg" alt="Image1"/>
                      </td>
                      <td class="list-cell-right">
                        <h1 class="card-title">Built-in Blocks
                        </h1>
                        <p class="card-text">Drag and drop built-in blocks from the right panel and style them in a matter of seconds
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table class="list-item">
              <tr>
                <td class="list-item-cell">
                  <table class="list-item-content">
                    <tr class="list-item-row">
                      <td class="list-cell-left">
                        <img class="list-item-image" src="http://artf.github.io/grapesjs/img/tmp-tgl-images.jpg" alt="Image2"/>
                      </td>
                      <td class="list-cell-right">
                        <h1 class="card-title">Toggle images
                        </h1>
                        <p class="card-text">Build a good looking newsletter even without images enabled by the email clients
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table class="grid-item-row">
              <tr>
                <td class="grid-item-cell2-l">
                  <table class="grid-item-card">
                    <tr>
                      <td class="grid-item-card-cell">
                        <img class="grid-item-image" src="http://artf.github.io/grapesjs/img/tmp-send-test.jpg" alt="Image1"/>
                        <table class="grid-item-card-body">
                          <tr>
                            <td class="grid-item-card-content">
                              <h1 class="card-title">Test it
                              </h1>
                              <p class="card-text">You can send email tests directly from the editor and check how are looking on your email clients
                              </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td class="grid-item-cell2-r">
                  <table class="grid-item-card">
                    <tr>
                      <td class="grid-item-card-cell">
                        <img class="grid-item-image" src="http://artf.github.io/grapesjs/img/tmp-devices.jpg" alt="Image2"/>
                        <table class="grid-item-card-body">
                          <tr>
                            <td class="grid-item-card-content">
                              <h1 class="card-title">Responsive
                              </h1>
                              <p class="card-text">Using the device manager you'll always send a fully responsive contents
                              </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table class="footer">
              <tr>
                <td class="footer-cell">
                  <div class="c2577">
                    <p class="footer-info">GrapesJS Newsletter Builder is a free and open source preset (plugin) used on top of the GrapesJS core library.
                  For more information about and how to integrate it inside your applications check<p>
                  <a class="link" href="https://github.com/artf/grapesjs-preset-newsletter">GrapesJS Newsletter Preset</a>
                    <br/>
                  </div>
                  <div class="c2421">
                    MADE BY <a class="link" href="https://github.com/artf">ARTUR ARSENIEV</a>
                    <p>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php echo $data->code;?>
<style>

  .link {
    color: rgb(217, 131, 166);
  }
  .row{
    vertical-align:top;
  }
  .main-body{
    min-height:150px;
    padding: 5px;
    width:100%;
    height:100%;
    background-color:rgb(234, 236, 237);
  }
  .c926{
    color:rgb(158, 83, 129);
    width:100%;
    font-size:50px;
  }
  .cell.c849{
    width:11%;
  }
  .c1144{
    padding: 10px;
    font-size:17px;
    font-weight: 300;
  }
  .card{
    min-height:150px;
    padding: 5px;
    margin-bottom:20px;
    height:0px;
  }
  .card-cell{
    background-color:rgb(255, 255, 255);
    overflow:hidden;
    border-radius: 3px;
    padding: 0;
    text-align:center;
  }
  .card.sector{
    background-color:rgb(255, 255, 255);
    border-radius: 3px;
    border-collapse:separate;
  }
  .c1271{
    width:100%;
    margin: 0 0 15px 0;
    font-size:50px;
    color:rgb(120, 197, 214);
    line-height:250px;
    text-align:center;
  }
  .table100{
    width:100%;
  }
  .c1357{
    min-height:150px;
    padding: 5px;
    margin: auto;
    height:0px;
  }
  .darkerfont{
    color:rgb(65, 69, 72);
  }
  .button{
    font-size:12px;
    padding: 10px 20px;
    background-color:rgb(217, 131, 166);
    color:rgb(255, 255, 255);
    text-align:center;
    border-radius: 3px;
    font-weight:300;
  }
  .table100.c1437{
    text-align:left;
  }
  .cell.cell-bottom{
    text-align:center;
    height:51px;
  }
  .card-title{
    font-size:25px;
    font-weight:300;
    color:rgb(68, 68, 68);
  }
  .card-content{
    font-size:13px;
    line-height:20px;
    color:rgb(111, 119, 125);
    padding: 10px 20px 0 20px;
    vertical-align:top;
  }
  .container{
    font-family: Helvetica, serif;
    min-height:150px;
    padding: 5px;
    margin:auto;
    height:0px;
    width:90%;
    max-width:550px;
  }
  .cell.c856{
    vertical-align:middle;
  }
  .container-cell{
    vertical-align:top;
    font-size:medium;
    padding-bottom:50px;
  }
  .c1790{
    min-height:150px;
    padding: 5px;
    margin:auto;
    height:0px;
  }
  .table100.c1790{
    min-height:30px;
    border-collapse:separate;
    margin: 0 0 10px 0;
  }
  .browser-link{
    font-size:12px;
  }
  .top-cell{
    text-align:right;
    color:rgb(152, 156, 165);
  }
  .table100.c1357{
    margin: 0;
    border-collapse:collapse;
  }
  .c1769{
    width:30%;
  }
  .c1776{
    width:70%;
  }
  .c1766{
    margin: 0 auto 10px 0;
    padding: 5px;
    width:100%;
    min-height:30px;
  }
  .cell.c1769{
    width:11%;
  }
  .cell.c1776{
    vertical-align:middle;
  }
  .c1542{
    margin: 0 auto 10px auto;
    padding:5px;
    width:100%;
  }
  .card-footer{
    padding: 20px 0;
    text-align:center;
  }
  .c2280{
    height:150px;
    margin:0 auto 10px auto;
    padding:5px 5px 5px 5px;
    width:100%;
  }
  .c2421{
    padding:10px;
  }
  .c2577{
    padding:10px;
  }
  .footer{
    margin-top: 50px;
    color:rgb(152, 156, 165);
    text-align:center;
    font-size:11px;
    padding: 5px;
  }
  .quote {
    font-style: italic;
  }

  .list-item{
    height:auto;
    width:100%;
    margin: 0 auto 10px auto;
    padding: 5px;
  }
  .list-item-cell{
    background-color:rgb(255, 255, 255);
    border-radius: 3px;
    overflow: hidden;
    padding: 0;
  }
  .list-cell-left{
    width:30%;
    padding: 0;
  }
  .list-cell-right{
    width:70%;
    color:rgb(111, 119, 125);
    font-size:13px;
    line-height:20px;
    padding: 10px 20px 0px 20px;
  }
  .list-item-content{
    border-collapse: collapse;
    margin: 0 auto;
    padding: 5px;
    height:150px;
    width:100%;
  }
  .list-item-image{
    color:rgb(217, 131, 166);
    font-size:45px;
    width: 100%;
  }

  .grid-item-image{
    line-height:150px;
    font-size:50px;
    color:rgb(120, 197, 214);
    margin-bottom:15px;
    width:100%;
  }
  .grid-item-row {
    margin: 0 auto 10px;
    padding: 5px 0;
    width: 100%;
  }
  .grid-item-card {
    width:100%;
    padding: 5px 0;
    margin-bottom: 10px;
  }
  .grid-item-card-cell{
    background-color:rgb(255, 255, 255);
    overflow: hidden;
    border-radius: 3px;
    text-align:center;
    padding: 0;
  }
  .grid-item-card-content{
    font-size:13px;
    color:rgb(111, 119, 125);
    padding: 0 10px 20px 10px;
    width:100%;
    line-height:20px;
  }
  .grid-item-cell2-l{
    vertical-align:top;
    padding-right:10px;
    width:50%;
  }
  .grid-item-cell2-r{
    vertical-align:top;
    padding-left:10px;
    width:50%;
  }
  
</style>


    </div>



 


    <div id="info-cont" style="display:none">
      <br/>
      <svg class="grapesjs-logo" xmlns="http://www.w3.org/2000/svg" version="1"><g id="gjs-logo"><path d="M40 5l-12.9 7.4 -12.9 7.4c-1.4 0.8-2.7 2.3-3.7 3.9 -0.9 1.6-1.5 3.5-1.5 5.1v14.9 14.9c0 1.7 0.6 3.5 1.5 5.1 0.9 1.6 2.2 3.1 3.7 3.9l12.9 7.4 12.9 7.4c1.4 0.8 3.3 1.2 5.2 1.2 1.9 0 3.8-0.4 5.2-1.2l12.9-7.4 12.9-7.4c1.4-0.8 2.7-2.2 3.7-3.9 0.9-1.6 1.5-3.5 1.5-5.1v-14.9 -12.7c0-4.6-3.8-6-6.8-4.2l-28 16.2" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-width:10;stroke:#fff"/></g></svg>
      <br/>
      <div class="gjs-import-label">
        <b>GrapesJS Newsletter Builder</b> is a showcase of what/how is possible to build an editor using the
        <a class="info-link gjs-color-active" target="_blank" href="http://artf.github.io/grapesjs/">GrapesJS</a>
        core library. Is not intended to represent a complete builder solution.
        <br/><br/>
        For any tip about this demo (or newsletters construction in general) check the
        <a class="info-link gjs-color-active" target="_blank" href="https://github.com/artf/grapesjs-preset-newsletter">Newsletter Preset repository</a>
        and open an issue. For any problem with the builder itself, open an issue on the main
        <a class="info-link gjs-color-active" target="_blank" href="https://github.com/artf/grapesjs">GrapesJS repository</a>.
        <br/><br/>
        Being a free and open source project contributors and supporters are extremely welcome.
      </div>
    </div>

<form action="" style="float:left;" method="post">
<input type="submit" value="Save Changes" name="sss"/>
</form>

<a href="#" id="ppp">Update This Template</a>


<form id="popup_form" action="<?=BASEURL;?>administrator/updatenewsletter" method="post" style="float:right">
<span>X</span>
<label style="color:white;">Are You Sure You want to save these changes ?</label><br><br/>
<input type="hidden" name="id1" id="id1" value=""/>
<input type="hidden" name="template_name" value="<?php echo $data->name; ?>"/>
 <input type="hidden" name="id"  value="<?php echo $data->id; ?>"/>
 <input type="submit" id="submit" name="submit" value="Yes"/> 
 <b>No</b>
</form>



    <script type="text/javascript">
	
      var host = 'http://localhost/bdforsale.com/';
      var images = [
        host + 'img/grapesjs-logo.png',
        host + 'img/tmp-blocks.jpg',
        host + 'img/tmp-tgl-images.jpg',
        host + 'img/tmp-send-test.jpg',
        host + 'img/tmp-devices.jpg',
      ];


      // Set up GrapesJS editor with the Newsletter plugin
      var editor = grapesjs.init({
        clearOnRender: true,
        height: '100%',
        storageManager: {
         id: 'gjs-',             // Prefix identifier that will be used on parameters
    type: 'local',          // Type of the storage
    stepsBeforeSave: 1,     // If autosave enabled, indicates how many changes are necessary before store method is triggered
	},
        assetManager: {
          assets: images,
          upload: 0,
          uploadText: 'Uploading is not available in this demo',
        },
        container : '#gjs',
        fromElement: true,
        plugins: ['gjs-preset-newsletter', 'gjs-plugin-ckeditor'],
        pluginsOpts: {
          'gjs-preset-newsletter': {
            modalLabelImport: 'Paste all your code here below and click import',
            modalLabelExport: 'Copy the code and use it wherever you want',
            codeViewerTheme: 'material',
            //defaultTemplate: templateImport,
            importPlaceholder: '<table class="table"><tr><td class="cell">Hello world!</td></tr></table>',
            cellStyle: {
              'font-size': '12px',
              'font-weight': 300,
              'vertical-align': 'top',
              color: 'rgb(111, 119, 125)',
              margin: 0,
              padding: 0,
            }
          },
          'gjs-plugin-ckeditor': {
            position: 'center',
            options: {
              startupFocus: true,
              extraAllowedContent: '*(*);*{*}', // Allows any class and any inline style
              allowedContent: true, // Disable auto-formatting, class removing, etc.
              enterMode: CKEDITOR.ENTER_BR,
              extraPlugins: 'sharedspace,justify,colorbutton,panelbutton,font',
              toolbar: [
                { name: 'styles', items: ['Font', 'FontSize' ] },
                ['Bold', 'Italic', 'Underline', 'Strike'],
                {name: 'paragraph', items : [ 'NumberedList', 'BulletedList']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'colors', items: [ 'TextColor', 'BGColor' ]},
              ],
            }
          }
        }
      });
//editor.DomComponents.clear();


var str = editor.getHtml();
var str1=editor.getCss();
var code11='<html><head><style>'+str1+'</style></head><body>'+str+'</body></html>';
$("#submit").click(function(){
 $('#id1').val(code11);
 });
  
   
      // Let's add in this demo the possibility to test our newsletters
      var mdlClass = 'gjs-mdl-dialog-sm';
      var pnm = editor.Panels;
      var cmdm = editor.Commands;
      var md = editor.Modal;
      /*
      var testContainer = document.getElementById("test-form");
      var contentEl = testContainer.querySelector('input[name=body]');
      cmdm.add('send-test', {
        run(editor, sender) {
          sender.set('active', 0);
          var modalContent = md.getContentEl();
          var mdlDialog = document.querySelector('.gjs-mdl-dialog');
          var cmdGetCode = cmdm.get('gjs-get-inlined-html');
          contentEl.value = cmdGetCode && cmdGetCode.run(editor);
          mdlDialog.className += ' ' + mdlClass;
          testContainer.style.display = 'block';
          md.setTitle('Test your Newsletter');
          md.setContent('');
          md.setContent(testContainer);
          md.open();
          md.getModel().once('change:open', function() {
            mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
            //clean status
          })
        }
      });
      pnm.addButton('options', {
        id: 'send-test',
        className: 'fa fa-paper-plane',
        command: 'send-test',
        attributes: {
          'title': 'Test Newsletter',
          'data-tooltip-pos': 'bottom',
        },
      });

      var statusFormElC = document.querySelector('.form-status');
      var statusFormEl = document.querySelector('.form-status i');
      var ajaxTest = ajaxable(testContainer).
        onStart(function(){
          statusFormEl.className = 'fa fa-refresh anim-spin';
          statusFormElC.style.opacity = '1';
          statusFormElC.className = 'form-status';
        })
        .onResponse(function(res){
          if (res.data) {
            statusFormElC.style.opacity = '0';
            statusFormEl.removeAttribute('data-tooltip');
            md.close();
          } else if(res.errors || res.errors == '') {
            var err = res.errors || 'Server error';
            statusFormEl.className = 'fa fa-exclamation-circle';
            statusFormEl.setAttribute('data-tooltip', err);
            statusFormElC.className = 'form-status text-danger';
          }
        });
      */

      // Add info command
      var infoContainer = document.getElementById("info-panel");
      cmdm.add('open-info', {
        run: function(editor, sender) {
          sender.set('active', 0);
          var mdlDialog = document.querySelector('.gjs-mdl-dialog');
          mdlDialog.className += ' ' + mdlClass;
          infoContainer.style.display = 'block';
          md.setTitle('About this demo');
          md.setContent('');
          md.setContent(infoContainer);
          md.open();
          md.getModel().once('change:open', function() {
            mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
          })
        }
      });
      pnm.addButton('options', [{
        id: 'undo',
        className: 'fa fa-undo',
        attributes: {title: 'Undo'},
        command: function(){ editor.runCommand('core:undo') }
      },{
        id: 'redo',
        className: 'fa fa-repeat',
        attributes: {title: 'Redo'},
        command: function(){ editor.runCommand('core:redo') }
      },{
        id: 'clear-all',
        className: 'fa fa-trash icon-blank',
        attributes: {title: 'Clear canvas'},
        command: {
          run: function(editor, sender) {
            sender && sender.set('active', false);
            if(confirm('Are you sure to clean the canvas?')){
              editor.DomComponents.clear();
              setTimeout(function(){
                localStorage.clear();
              },0)
            }
          }
        }
      },{
        id: 'view-info',
        className: 'fa fa-question-circle',
        command: 'open-info',
        attributes: {
          'title': 'About',
          'data-tooltip-pos': 'bottom',
        },
      }]);

      // Simple warn notifier
      var origWarn = console.warn;
      toastr.options = {
        closeButton: true,
        preventDuplicates: true,
        showDuration: 250,
        hideDuration: 150
      };
      console.warn = function (msg) {
        toastr.warning(msg);
        origWarn(msg);
      };

      // Beautify tooltips
      var titles = document.querySelectorAll('*[title]');
      for (var i = 0; i < titles.length; i++) {
        var el = titles[i];
        var title = el.getAttribute('title');
        title = title ? title.trim(): '';
        if(!title)
          break;
        el.setAttribute('data-tooltip', title);
        el.setAttribute('title', '');
      }


      // Do stuff on load
      editor.on('load', function() {
        var $ = grapesjs.$;

        // Show logo with the version
        var logoCont = document.querySelector('.gjs-logo-cont');
        document.querySelector('.gjs-logo-version').innerHTML = 'v' + grapesjs.version;
        var logoPanel = document.querySelector('.gjs-pn-commands');
        logoPanel.appendChild(logoCont);

        // Move Ad
        $('#gjs').append($('.ad-cont'));
      });
	  
	
    </script>
    <script>
	
$('#ppp').click(function(){
$('#popup_form').fadeIn();	
});	

$('#popup_form span, #popup_form b').click(function(){
$('#popup_form').fadeOut();	
});

$('#reload_nav').click(function(){
location.reload(true);	
});

</script>
<script>
var dom = document.documentElement.outerHTML;
dom.replace(/\n\s+|\n/g, "");
<?php if(!isset($_POST['sss'])) { ?>
var tt = '<?php echo $data->code;?>';
<?php } ?>
//alert('tee');
localStorage.setItem("username", tt);
var vv = localStorage.getItem("username");
editor.setComponents(vv);



</script>
    
  </body>
</html>
