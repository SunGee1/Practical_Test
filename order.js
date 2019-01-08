var table = null;

$(document).ready( function () {
   	ViewOrdersTable();

});

function ViewOrdersTable ()
{
	$.ajax(
		{
			url : "view_table.php",
			dataType : "JSON",
			success : function(rows)
			{
				if(!table)
				{
					table = $('#view_order_table').DataTable(
					{
						dom: 'Bfrtip',
	    				buttons: 
	    				[
	            			'copy', 'csv', 'excel', 'pdf', 'print'
	        			]
        			});
				}
				// Find and remove all rows greater then row one in view_order_table
				// $("#view_order_table").find("tr:gt(0)").remove();
				table.clear();
				// rebuild table
				for (index = 0; index < rows.length; ++index) {
					var  order = {firstname: rows[index].firstname,
									order_id: rows[index].id,
									value: rows[index].Value,
									order_date: rows[index].order_date,
									order_update: rows[index].order_update,
									status: rows[index].Status
					};
					AddOrderToTable(order);
				};
			},
			error : function(jqXHR, textStatus, errorThrown)
			{
				console.log(textStatus, errorThrown);
			}
		});
}

function OrderDialog (order_number = false)
{
    	ClearOrderForm();
    	var title = "Place new order";
		if (order_number)
		{
			title = "Update order "+order_number;
			PopulateUpdateOrderTable(order_number);
		}

		$("#place_order_table").dialog
		(
			{
				title: title,
				modal: true,
				height: "auto",
				width: "350px",
				buttons: 
				{
		    	    Cancel: function() 
		    	    {
		    	    	$(this).dialog('close');
		    	    }
				}
			}
		);

		Toggle_order_type_button(order_number);
}

function Toggle_order_type_button(clicked_button)
{
	if (!clicked_button)
	{
		if($('#place_order_button').is(':visible'))
		{
			if($('#update_order_button').is(':visible'))
			{
				$("#update_order_button").toggle();
			}
		} else
		{
			$("#place_order_button").toggle();
			if($('#update_order_button').is(':visible'))
			{
				$("#update_order_button").toggle();
			}
		}
	}
	else
	{
		if($('#update_order_button').is(':visible'))
		{
			if($('#place_order_button').is(':visible'))
			{
				$("#place_order_button").toggle();
			}
		} else
		{
			$("#update_order_button").toggle();
			if($('#place_order_button').is(':visible'))
			{
				$("#place_order_button").toggle();
			}
		}
	}
}

function PlaceOrder ()
{
	var products = [];
	var count = 0;
	$('.order_product').each(function()
	{
		if(($(this).val() == "") || ($(this).val() == 0))
		{
			return;
		}
		count++;
		products.push({product_id: $(this).attr("id"), product_cost: $(this).attr("cost"), product_quantity: $(this).val()});
		$(this).val("");
	});

	if (count != 0)
	{
		console.log(products);
		count = 0;
		$.ajax(
		{
			url : "place_order.php",
			data : {products: products},
			dataType : "json",
			type : 'POST',
			success : function(result)
			{
				AddOrderToTable(result);
				$("#place_order_table").dialog('close');
			},
		    error : function(jqXHR, textStatus, errorThrown)
		    {
		        console.log(textStatus, errorThrown);
		    }
		});
	}
	else
	{
		ErrorDialog("Warning!", "Fields can not be empty");
	}
}

function CancelOrder(orderNum)
{
	$('#error_dialog').html("Do you really want to cancel the order?");
	$('#error_dialog').dialog
	({
		title: "Notice",
		modal: true,
		height: "auto",
		width: "auto",
		buttons:
		{
			"Yes": function()
			{
				$.ajax(
				{
					url : "cancel_order.php",
					data : {order_number: orderNum},
					dataType : "text",
					type : 'POST',
					success : function(success)
					{
						// add code here to update table row only, live.
						ViewOrdersTable();
					},
			        error : function(jqXHR, textStatus, errorThrown)
			        {
			            console.log(textStatus, errorThrown);
			        }
				});
    	    	$(this).dialog('close');
			},
			"No": function()
			{
    	    	$(this).dialog('close');
			}
		}
	});
}

function PopulateUpdateOrderTable(orderNum)
{
		$.ajax(
		{
			url : "get_order_details.php",
			data : {orderNum: orderNum}, 
			dataType : "json",
			type : "POST",
			success : function(result)
			{
				$("#update_order_button").find("input").attr("onclick", "UpdateOrder("+ orderNum +")");
				ClearOrderForm();
				for (rowIndex = 0; rowIndex < result.length; ++rowIndex)
				{
					$('.order_product').each(function()
					{
						var productID = $(this).attr("id");
						if(productID == result[rowIndex].product_ref)
						{
							$(this).val(result[rowIndex].quantity);
							return;
						}
					});

				};
			},
			error : function(jqXHR, textStatus, errorThrown)
			{
				console.log(textStatus, errorThrown);
			}
		});
}

function ClearOrderForm()
{
	$(".order_product").each(function()
	{
		$(this).val("");
	});
}

function UpdateOrder(orderNum)
{
	var product_quantities = [];
	// console.log(orderNum);
	$('.order_product').each(function()
	{
		if(($(this).val() == "") || ($(this).val() == 0))
		{
			return;
		}
		product_quantities.push({product_id: $(this).attr("id"), product_quantity: $(this).val()});
		$(this).val("");
	});

	$.ajax(
	{
		url : "update_order.php",
		data : {order_number: orderNum, products: product_quantities},
		dataType : "json",
		type : 'POST',
		success : function(result)
		{
			ViewOrdersTable();
			$("#place_order_table").dialog('close');
		},
        error : function(jqXHR, textStatus, errorThrown)
        {
            console.log(textStatus, errorThrown);
        }
	});
	$('#order_num_text_box').val("");
}

function UpdateRow(result)
{
	// add code to update row only

	// $("#view_order_table tbody td").text("Picked")
	// var table = $('#view_order_table').DataTable();
	// table.row( this ).data( result ).draw();

	// console.log(result);
}

function AddOrderToTable(order)
{
	if(!table)
	{
		table = $('#view_order_table').DataTable(
		{
			dom: 'Bfrtip',
			buttons: 
			[
    			'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	}
	var buttons = "<input id='row_button_update_order_"+order.order_id+"' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog("+order.order_id+")' value='Update order'><input id='row_button_cancel_order_"+order.order_id+"' type='button' class='ui-button ui-corner-all ui-widget' onclick='CancelOrder("+order.order_id+")' value='Cancel order'>";
	if (order.status == "Canceled")
	{
		buttons = "";
	}
	table.row.add([
					order.firstname,
					order.order_id,
					"R" + order.value + ".00",
					order.order_date,
					order.order_update,
					order.status,
					buttons
				]).draw();
	// console.log(order.status);
}

function ErrorDialog(dialog_title, error_message)
{
	$('#error_dialog').html(error_message);
	$('#error_dialog').dialog
	(
		{
			title: dialog_title,
			modal: true,
			height: "auto",
			width: "auto",
			buttons: 
			{
	    	    OK: function() 
	    	    {
	    	    	$(this).dialog('close');
	    	    }
			}
		}
	);
}
