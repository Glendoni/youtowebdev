<?php
echo 'Glen';

?>

<style>
body { font-family: tahoma; }

ol,
ul { list-style: outside none none; }

#container {
  margin: 0 auto;
  width: 60rem;
}

.tags {
  background: none repeat scroll 0 0 #fff;
  border: 1px solid #ccc;
  display: table;
  padding: 0.5em;
  width: 100%;
}

.tags li.tagAdd,
.tags li.addedTag {
  float: left;
  margin-left: 0.25em;
  margin-right: 0.25em;
}

.tags li.addedTag {
  background: none repeat scroll 0 0 #1ABC9C;
  border-radius: 5px;
  color: #fff;
  padding: .5em;
}

.tags input,
li.addedTag {
  border: 1px solid transparent;
  border-radius: 5px;
  box-shadow: none;
  display: block;
  padding: 0.5em;
}

.tags input:hover { border: 1px solid #000; }

span.tagRemove {
  cursor: pointer;
  display: inline-block;
  padding-left: 0.5em;
}

span.tagRemove:hover { color: #222222; }


p { color: #ccc; }

h1 {
  color: #6b6b6b;
  font-size: 1.5em;
}
</style>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">


<div id="container" style="margin-top:150px;">
  <h1>Sonovate Tagging</h1>
  <ul class="tags">
    <li class="addedTag">JavaScript<span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="Web Deisgn">
    </li>
    <li class="addedTag">Html5<span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="Web Develop">
    </li>
    <li class="addedTag">CSS3<span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="SEO">
    </li>
    <li class="tagAdd taglist">
      <input type="text" id="tags-field">
    </li>
  </ul>
</div>
 <?=$jq;?>
<script>
  $(document).ready(function() {
$('#addTagBtn').click(function() {
                $('#tags option:selected').each(function() {
                    $(this).appendTo($('#selectedTags'));
                });
            });
            $('#removeTagBtn').click(function() {
                $('#selectedTags option:selected').each(function(el) {
                    $(this).appendTo($('#tags'));
                });
            });
 $('.tagRemove').click(function(event) {
                event.preventDefault();
                $(this).parent().remove();
            });
            $('ul.tags').click(function() {
                $('#tags-field').focus();
            });
            $('#tags-field').keypress(function(event) {
                if (event.which == '13') {
                    if ($(this).val() != '') {
                        $('<li class="addedTag">' + $(this).val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + $(this).val() + '" name="tags[]"></li>').insertBefore('.tags .tagAdd');
                        $(this).val('');
                    }
                }
            });

  });
  
</script>



<script type="text/javascript" src="<?=$test?>"></script>