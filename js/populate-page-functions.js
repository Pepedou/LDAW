
	function populateForm(type)
	{
		// grab the correct input and output elements
			var form		= document.forms['form_' + type];
			var formJSON	= document.forms['json_' + type];
			
		// create the text variables
			var text		= formJSON['json'].value;
			text			= text.replace(/(^\s+|\s+$)/, '');
			text			= "(" + text + ");";

		// attempt to create valid JSON
			try
			{
				var json = eval(text)
			}
			catch(err)
			{
				alert('That appears to be invalid JSON!')
				return false;
			}
			
		// populate the form if no error
			$(form).populate(json, {debug:1})
	}
		
	function resetForms(type)
	{
		document.forms['form-' + type].reset()
		document.forms['json-' + type].reset()
	}


