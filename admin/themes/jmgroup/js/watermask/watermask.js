/**
 * Created by ManTran on 7/17/2015.
 */
$(function(){
    // create a wrapper around native canvas element (with id="c")
    var canvas = new fabric.Canvas('canvas'),
        $canvas = $('#canvas'),
        btnAddWatermask = $('#add-watermask-button'),
        btnDeleteWatermask = $('#delete-watermask-button'),
        btnAddText = $('#add-text-button'),
        btnAddFrame = $('#add-frame-button'),
        ctrlZone = $('#color-opacity-controls'),
        ctrlOpacity = ctrlZone.find('input[type="range"]'),
        ctrlColor = ctrlZone.find('input[type="color"]');

    canvas.setBackgroundImage($canvas.data('background'), canvas.renderAll.bind(canvas));

    btnAddWatermask.on('click', function(){
        mihaildev.elFinder.openManager({
            filter:'image',
            path:'image',
            callback:'addImage',
            url:'/admin/elfinder/manager?filter=image&path=image&callback=addImage',
            width:'auto',
            height:'auto',
            id:'addImage'
        });
    });
    mihaildev.elFinder.register('addImage', function(file, id){
        var imgElement = new Image();
        imgElement.src = file.url;
        imgElement.onload = function(){
            var imgInstance = new fabric.Image(imgElement, {
                left: 10,
                top: 10
            });
            canvas.add(imgInstance);
        };
        return true;
    });

    btnDeleteWatermask.on('click', function(){
        var obj = canvas.getActiveObject();
        canvas.remove(obj);
    });

    btnAddText.on('click', function(){
        var text = new fabric.IText('www.vitinhgiatot.com', {
            left: 100,
            top: 100,
            fontFamily: 'Arial'
        });
        canvas.add(text);
    });

    btnAddFrame.on('click', function(){
        var rect = new fabric.Rect({
            left: 100,
            top: 50,
            width: 100,
            height: 100,
            fill: 'green',
            angle: 20,
            padding: 10
        });
        canvas.add(rect);
    });

    ctrlOpacity.on('change', function(){
        var obj = canvas.getActiveObject();
        obj.setOpacity($(this).val()/100);
        canvas.renderAll();
    });
    ctrlColor.on('change', function(){
        var obj = canvas.getActiveObject();
        obj.setColor($(this).val());
        canvas.renderAll();
    });
    canvas.on('object:selected', function(){
        var obj = canvas.getActiveObject();
        if(obj.text !== undefined){
            ctrlZone.show();
        }
        else {
            ctrlZone.hide();
        }
        ctrlOpacity.val(obj.opacity * 100);
        ctrlColor.val(rgb2hex(obj.fill));
        canvas.renderAll();

        btnDeleteWatermask.removeAttr('disabled').addClass('alert').removeClass('disabled');
    });
    canvas.on('selection:cleared', function(){
        btnDeleteWatermask.attr('disabled', 'disabled').removeClass('alert').addClass('disabled');
        ctrlZone.hide();
    });

    $('#watermask-save').on('click', function(){
        var url = $(this).data('submit');
        $.post(url, {
            'fabric': JSON.stringify(canvas)
        }, function(response){
            window.open(response.src,'Review','width=600,height=400,resizable=1');
        });
    });

    //Function to convert hex format to a rgb color
    function rgb2hex(orig){
        var rgb = orig.replace(/\s/g,'').match(/^rgba?\((\d+),(\d+),(\d+)/i);
        return (rgb && rgb.length === 4) ? "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : orig;
    }
});