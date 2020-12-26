

/* ============ TITLE TOOLTIP TOOGLE ============== */
	
	$(function () 
	{
		$('[data-toggle="tooltip"]').tooltip();
	});

/* ============ MENU CATEGORY TOOGLE ============== */

	function showCategoryMenus(evt, categoryName) 
	{
		var i, tab_category_content, tab_category_links;
		
		tab_category_content = document.getElementsByClassName("tab_category_content");
		
		for (i = 0; i < tab_category_content.length; i++) 
		{
			tab_category_content[i].style.display = "none";
		}
		
		tab_category_links = document.getElementsByClassName("tab_category_links");
		
		for (i = 0; i < tab_category_links.length; i++) 
		{
			tab_category_links[i].className = tab_category_links[i].className.replace(" active_category", "");
		}
		
		document.getElementById(categoryName).style.display = "block";
		evt.currentTarget.className += " active_category";
	}

/* ============ VALIDATE EMAIL  ============== */

  function ValidateEmail(mail) 
  {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
	{
		return (true);
	}
	
	return (false);
  }