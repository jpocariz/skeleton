
/* CRUD template js */
$(".admin-form form button[type='submit']").unbind('click').on('click',function(event){
	event.preventDefault();
	
	var id = this.id;
	//find the forms submitbutton
	var submitButton = $(this);//$("#"+id+" button[type='submit']"),
		btnHtml = submitButton.html(),
		loadHtml = $("#"+id+" .whileLoad").html();
	submitButton.unbind('click');
	submitButton.html(loadHtml);
	//disable it for user experience and to prevent double submits
	submitButton.addClass('disabled');
	submitButton.attr('disabled','disabled');
	//save current button html so it can be restored
	var formFields=$(this).closest('form').serialize(),
	url = "/post/create";					
	$.ajax({
	   type: 'POST',
	    url: url,
	    dataType: 'json',
	   	data:formFields,
		success:function(data){
			console.log(data);
  			var data = jQuery.parseJSON(data);
			if(data !== null && data.success){
      			$(".admin-form form")[0].reset();      			
				try{
					$(".admin-form").slideUp();
					$.fn.yiiGridView.update('post-grid', { });	                                  
   			 	}catch(err){}
	   			 	$.pnotify({
				    	title: 'Success',
				    	text: 'Saved your post',
				    	icon: 'icon-ok',
				    	type: 'success',
			    	});
		    }
		//restore the submit button
		submitButton.html(btnHtml);
       	submitButton.removeClass('disabled');
       	submitButton.removeAttr('disabled');
	   },
	   error: function(data) {
	          alert(JSON.stringify(data)); 
	    },
	  dataType:'html'
	  });

	return false;
});
function renderUpdateForm(id,modelClass,url)
{
	url = typeof url == 'undefined' ? "jsonAttributes" : url;
  	$.ajax({
  		type: 'POST',
    	url: url,
   		data:{"id":id},
		success:function(data){
			var settings = modalDefaults();
			data = $.parseJSON(data);
			$.each(data, function(index, value) {
				var selector = "#"+modelClass+"_"+index;
				try{
					$(".admin-form "+selector).val(value);
				}catch(err){
				}
			});
			$(".admin-form").slideDown();
        },
   error: function(data) { // if error occured
           alert(JSON.stringify(data)); 
         alert("Error occured.please try again");
    },

  dataType:'html'
  });

}

/* render view in modal */

function renderView(id,url)
{ 
url = typeof url == 'undefined' ? "view" : url;
 var data="id="+id;

  $.ajax({
  	type: 'POST',
 	url: url,
  	data:data,
	success:function(data){		
		$(".admin-form").slideUp('slow');
		$(".search-form").slideUp('slow');
		$(".view-content").html(data);
		$(".view-wrapper").slideDown();
   },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
    },

  dataType:'html'
  });

}


//deletes a post if the dialog is confirmed
function delete_record(id,modelClass,url)
{
	url = typeof url == 'undefined' ? "/"+modelClass+"/delete" : url;

	console.log($(this).parents());
	bootbox.dialog("Are you sure you want to delete?", [
		{
		"label" : "No",
		"class" : "btn-danger",
		"callback": function() {}
		}, 
		{
		"label" : "Yes",
		"class" : "btn-success",
		"callback": function() {
			  $.ajax({
			    type: 'POST',
			    url: url,
		        data:{id:id,modelClass:modelClass},
				success:function(data){
					data = $.parseJSON(data);
					var grid = data.modelClass.toLowerCase();
	                 $.fn.yiiGridView.update(grid+'-grid', { });	                                  
			    },
			   error: function(data) { 
			         alert("Error occured.please try again");
			    },
			  dataType:'html'
			  });
		  }
		 },
		]
	);		
}


// toggle the  search form
$('body').on('click','.toggleSearch', function(){
	$(".admin-form").slideUp('slow');
	$(".view-wrapper").slideUp('slow');
    $('.search-form').slideToggle('slow');
    return false;
});


//displaying create/update form
$("body").on('click',".toggleForm",function(){
	$(".search-form").slideUp('slow');
	$(".view-wrapper").slideUp('slow');
	$(".admin-form").slideToggle('slow');

});

//hide the  view content form
$('body').on('click','.closeViewContent', function(){
	$(".admin-form").slideUp('slow');
	$(".search-form").slideUp('slow');
	$(".view-wrapper").slideUp('slow');
});

//making a search
$('body').on('submit','.search-form form',function(){
    $.fn.yiiGridView.update($(this).attr('data-target'), {
        data: $(this).serialize()
    });
    return false;
});
/* end template js*/