$(document).ready(function(e){
	
    // process login form

	// process sign-up form

    // filter laws list
	$(".filterSearch").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filterList a").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	
	// load laws from server
	$("#laws").on('click','.lawURL',function(){
		event.preventDefault();
		var url = $(this).attr('href');
		$("#laws").html("");
		$("#lawsContent").load(url, function(responseTxt, statusTxt, xhr){
			if(statusTxt == "success"){
				//alert("External content loaded successfully!");
			}
			if(statusTxt == "error"){
				alert("Sorry: This law is not available at the moment. " + xhr.status + ": " + xhr.statusText);
				//alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	});
	
	// load rules from server
	$("#rules").on('click','.ruleURL',function(){
		event.preventDefault();
		var url = $(this).attr('href');
		//$("#rules").html("");
		$("#rules").load(url, function(responseTxt, statusTxt, xhr){
			if(statusTxt == "success"){
				//alert("External content loaded successfully!");
			}
			if(statusTxt == "error"){
				alert("Sorry: This rule is not available at the moment. " + xhr.status + ": " + xhr.statusText);
				//alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	});

	// if user is on news page
	if((window.location.pathname.split("/").pop()) == 'news.php'){
		// get news content from api
		$("#news").on('click','.newsContent',function(){
			var url2 = 'http://lawcompanion.website/public/news/'+$(this).attr('href');
			var info = '';
			
			$.ajax({url: url2, success: function(result){
				
				info+='<h3>'+result.title+'</h3><pre>'+result.content+'</pre><h6><a href='+result.authorURL+'>By '+result.author+'</a></h6><code>Last Updated: '+result.updated_at+'</code>';
				$("#news").html(info);
			
			}});

		});
		
		// fetch news from api
		var url = 'http://lawcompanion.website/public/api/news';
		var info = '';
		
		$.ajax({url: url, success: function(result){
			$.each(result, function(index, value){
				info+='<a href = "'+value.id+'" onclick="event.preventDefault()" class = "newsContent"><p>'+value.title+'</p></a>';
			});
			$("#news").html(info);
		}});
	}
	
	// if user is on properties page
	if((window.location.pathname.split("/").pop()) == 'properties.html'){
		$('#properties-set').on('click','.accordion-toggle',function(){
			
			//Expand or collapse this panel
			$(this).next().slideToggle(1000);

			//Hide the other panels
			$(".accordion-content").not($(this).next()).slideUp();

		});
		
		// fetch properties from api
		var url = 'http://lawcompanion.website/public/api/properties';
		var info = '';
		
		$.ajax({url: url, success: function(result){
			$.each(result, function(index, value){
				var tel = 'tel:'+value.phone;
				info+='<div class = "card" id="accordion"><div class="col-twelve accordion-toggle"><img src="http://lawcompanion.website/public/images/properties/'+value.imagePath+'" /><div><p class="folio-title">'+value.location+'</p><p class="folio-title"> ₦'+value.price+' &nbsp; <a href='+tel+'><u>'+value.phone+'</u></a></p></div></div><div  class="accordion-content col-twelve"><p class="folio-title" class = "properties">'+value.description+'</p></div></div>';
			});
			$("#properties-set").html(info);
		}});
	}
	
	// process ad request
    $("form.property-form").on('submit',function(e){
        e.preventDefault();
		
        $("#login").val('Connecting...');
		
        //var form = $(this);
		var formData = new FormData(this);
        
        var url = 'http://lawcompanion.website/public/api/properties';
        
        $.ajax({
            type: "POST",
            url: url,
			data: formData,
			success: function(data){
				if(!data){
					alert("An error occured, please try again.");
					$("#login").val('Post Advert');
				}
				else if(data == 1){
					alert("Success!");
				}
				else{
					alert("Failed to send advert, please try again.");
					$("#login").val('Try Again?');
				}
				
				$("#login").val('Success!');
                document.location.href = "properties.php";
			},
			cache: false,
			contentType: false,
			processData: false
        });
    });
});