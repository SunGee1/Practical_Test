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
			table.clear().draw();
			var order = {};
			if (isEmpty(rows))
			{
				for (index = 0; index < rows.length; ++index)
				{
					order = {firstname: rows[index].firstname,
							order_id: rows[index].id,
							value: rows[index].Value,
							order_date: rows[index].order_date,
							order_update: rows[index].order_update,
							status: rows[index].Status,
							buttons: rows[index].buttons
							};
					AddOrderToTable(order);
				}
			}
			else
			{
				table.clear().draw();
			}
		},
		error : function(jqXHR, textStatus, errorThrown)
		{
			console.log(textStatus, errorThrown);
		}
	});
}

function isEmpty(obj)
{
	for (var key in obj)
	{
		if (obj.hasOwnProperty(key))
		{
			return true;
		}
		return false;
	}
}

function calculateTotalOrderCost(item_id)
{
	var price = 0;
	$(".order_product").each(function(){
		var cost = $(this).attr("cost");
		var amount = $(this).val();
		price += (cost * amount);
	});
	$("#total_order_price_label").text("R"+price.toFixed(2));
}

function OrderDialog (order_number = false)
{
	$(".order_product").on("keyup", function(){
		var item_id = $(this).attr("id");
		calculateTotalOrderCost(item_id);
	});	

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

	var total_price = $("#total_order_price_label").text().replace("R", "");
	products.push({total_order_price : total_price});
	// console.log(total_price);
	if (count != 0)
	{
		count = 0;
		$.ajax(
		{
			url : "place_order.php",
			data : {products: products},
			dataType : "json",
			type : 'POST',
			success : function(result)
			{
				// result.items = products;
				console.log("You have successfully given money to buy items. CONGRATULATIONS!!!");
				if (result.hasOwnProperty("not_enough_money"))
				{
					console.log("money "+result.enough_money);
				}
				// AddOrderToTable(result);

				// $("#total_order_price_label").text("R0.00");
				// $("#place_order_table").dialog('close');
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

function Logout()
{
	$.ajax(
	{
		url : "logout.php",
		// data : session_user,
		// dataType : "json",
		type : 'POST',
		success : function(success)
		{
			// add code here to update table row only, live.
			// ViewOrdersTable();
		},
        error : function(jqXHR, textStatus, errorThrown)
        {
            console.log(textStatus, errorThrown);
        }
	});
}

function StatusUpdate(order_id, order_status, is_admin)
{	
	if (!is_admin)
	{
		$('#error_dialog').html("Do you really want to cancel order " + order_id + "?");
	} else
	{	
		$('#error_dialog').html("Please confirm delivery to client.");
	}
	$('#error_dialog').dialog
	({
		title: "Confirmation",
		modal: true,
		height: "auto",
		width: "auto",
		buttons:
		{
			"Yes": function()
			{
				$.ajax(
				{
					url : "status_update.php",
					data : {order: order_id, status: order_status, admin: is_admin},
					// dataType : "json",
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

function DeleteOrder(order_num)
{
	$('#error_dialog').html("Please confirm the deletion of order " + order_num + ".");
	$('#error_dialog').dialog
	({
		title: "Confirmation",
		modal: true,
		height: "auto",
		width: "auto",
		buttons:
		{
			"Delete": function()
			{
				$.ajax(
				{
					url : "delete_order.php",
					data : {orderNum: order_num},
					type : "POST",
					success : function()
					{
						ViewOrdersTable();
					},
					error : function(jqXHR, textStatus, errorThrown)
					{
						console.log(textStatus, errorThrown);
					}
				});
    	    	$(this).dialog('close');
			},
			"Cancel": function()
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

function CollectOrder(orderNum)
{
	$.ajax(
	{
		url : "collect_order.php",
		data : {orderNum: orderNum}, 
		// dataType : "json",
		type : "POST",
		success : function(result)
		{
			ViewOrdersTable();
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

function  AddOrderToTable(order)
{
	// var buttons = "";
	var status = "";
	// var items = null;

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

	// GetButtons(order);

	if (order.status == "Placed") /*Placed*/
	{
		// buttons = "<input id='row_button_update_order_"+order.order_id+"' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog("+order.order_id+")' value='Update order'><input id='row_button_cancel_order_"+order.order_id+"' type='button' class='ui-button ui-corner-all ui-widget' onclick='StatusUpdate("+order.order_id+")' value='Cancel order'>";
		status = "<font color='blue'>"+order.status+"</font>";
	} else if (order.status == "Delivered") /*Delivered*/
	{
		// buttons = "<input id='row_button_collect_order_"+order.order_id+"' type='button' class='ui-button ui-corner-all ui-widget' onclick='CollectOrder("+order.order_id+")' value='Collect order'>";
		status = "<font color='green'>"+order.status+"</font>";
	} else if (order.status == "Canceled") /*Canceled*/
	{
		// buttons = "";
		status = "<font color='red'>"+order.status+"</font>";
	} else /*Collected, Archived*/
	{
		// buttons = "";
		status = order.status;
	}

	// items = GetProductNames(order.order_id);
	
	table.row.add([
					order.firstname,
					"<div title=''><font color='purple'>"+order.order_id+"</font></div>",
					"R" + order.value + ".00",
					order.order_date,
					order.order_update,
					status,
					order.buttons
					// row_buttons
				]).draw();
}

function ShowInventory()
{
	if (true)
	{
		$('#inventory tbody').empty();
		$.ajax(
		{
			url : "get_inventory_items.php",
			dataType : "json",
			success : function(result)
			{
				var count = 0;
				$(result).each(function()
					{
						var row = "<tr id='eat_" + result[count].item_ref + "'>";
						row += "<td style='text-align:left'>" + result[count].description + "</td>";
						row += "<td style='text-align:left' id='eat_" + result[count].item_ref + "'>" + result[count].item_quantity + "</td>";
						row += "<td style='text-align:left'><input type='button' id='eat' class='ui-button ui-corner-all ui-widget' onclick='eatItem(" + result[count].item_ref + ")' value='Eat'></input></td>";
						row += "<td style='text-align:left'><input type='button' id='sell' class='ui-button ui-corner-all ui-widget' onclick='sellItemDialog(" + result[count].item_ref + "," + result[count].cost + ")' value='Sell'></input></td>";
						row += "</tr>";
						$('#inventory').find('tbody:last').append('<tr>' + row + '</tr>');
						// console.log(result[count].cost);
						count++;
						
					});

				$('#inventory').dialog
				({
					title:  "My Inventory",
					modal: true,
					height: "auto",
					width: "auto",
					buttons:
					{
						"Close": function()
						{
							if($('#sell_error').is(':visible'))
							{
								$("#sell_error").toggle();
							}
							$(this).dialog('close');
						}
					}
				});
			},
	        error : function(jqXHR, textStatus, errorThrown)
	        {
	            console.log(textStatus, errorThrown);
	        }
		});
	} else
	{
		alert("You have no items in your inventory");
	}
}

function sellItemDialog(item_ref, item_cost)
{
	if($("#sell_item_dialog").length == 0)
	{
		var cost = "R" + item_cost.toFixed(2) + " &times; ";
		$("html").append("<div id='sell_item_dialog' style='text-align:center;'><label id='item_cost_label' cost='" + item_cost + "'>" + cost + "</label><input type='text' id='sell_text_box' style='width: 65px' maxlength='5'><label id='total_sell_cost'> = R0.00</label></div>");
	}
	else if($("#item_cost_label").attr('cost') != item_cost)
	{
		$("#item_cost_label").html("R"+item_cost.toFixed(2) + " &times; ");
		$("#item_cost_label").attr('cost', item_cost);
	}

	$( "#sell_text_box" ).on( "keyup", function( /*event*/ ) {
  		var total_sell_cost = item_cost * $("#sell_text_box").val();
  		$("#total_sell_cost").text(" = R"+total_sell_cost.toFixed(2));
	});

	$('#sell_item_dialog').dialog
		({
			title:  "Specify sell amount",
			modal: true,
            width: 320,
            height: "auto",
			buttons:
			{
				"Confirm": function()
				{
					var amount = $("#sell_text_box").val();
					sellItem(item_ref, amount);
					$(this).dialog('close');
				}
			}
		});
	$('#sell_item_dialog').on('dialogclose', function(event) {
		$("#total_sell_cost").text(" = R0.00");
		$("#sell_text_box").val("");
	});

}

function sellItem(item_ref, sell_amount)
{

	$("#sell_text_box").val("");
	if($("#sell_error").length == 0)
	{
		$("#inventory").append("<div id='sell_error' style='text-align:center; display:none'><font color='red' size='3'>You can not sell more then what you have.</font></div>");
	}
	$.ajax(
	{
		url : "sell_item.php",
		data : {itemRef: item_ref, amount: sell_amount},
		dataType : "json",
		type : "POST",
		success : function(result)
		{
			if(!result.hasOwnProperty("new_amount"))
			{
				if(!$('#sell_error').is(':visible'))
				{
					$("#sell_error").toggle();
				}
			}
			else
			{
				if($('#sell_error').is(':visible'))
				{
					$("#sell_error").toggle();
				}

				if(result.new_amount <= 0)
				{
					$('div#inventory table tbody tr#eat_'+ item_ref).remove();
				}
				else
				{
					$('#inventory td#eat_'+ item_ref).html(result.new_amount);
				}
				var	money = "Money: R" + parseFloat(result.current_money).toFixed(2);
				$("#user_money").html(money);
				// alert("you have sold some items. You now have: " + result.new_amount);
			}
		},
        error : function(jqXHR, textStatus, errorThrown)
        {
            console.log(textStatus, errorThrown);
        }
    });
}

function eatItem(item_ref)
{
	$.ajax(
	{
		url : "eat_item.php",
		data : {itemRef : item_ref},
		dataType : "text",
		type : "POST",
		success : function(result)
		{
			if (result == 1)
			{
				$('div#inventory table tbody tr#eat_'+ item_ref).remove();
			}
			else
			{
				$('div#inventory table tbody tr td#eat_'+ item_ref).html(result - 1);
			}
		},
        error : function(jqXHR, textStatus, errorThrown)
        {
            console.log(textStatus, errorThrown);
        }
    });
}

function ArchiveOrder(order_num)
{
	$.ajax(
		{
			url : "archive_order.php",
			data : {orderNum : order_num},
			type : "POST",
			success : function(result)
			{
				ViewOrdersTable();
			},
	        error : function(jqXHR, textStatus, errorThrown)
	        {
	            console.log(textStatus, errorThrown);
	        }
	    });
}

function GetArchivedOrders()
{
	// $('#archive tbody').empty();
	$.ajax(
	{
		url : "get_archived_orders.php",
		// data : {orderNum : order_num},
		// type : "POST",
		dataType : "json",
		success : function(result)
		{
			var count = 0;
			$(result).each(function()
				{
					var row = "<td style='text-align:centre'>" + result[count].order_num + "</td>";
					row += "<td style='text-align:center'>" + result[count].Name + "</td>";
					row += "<td style='text-align:center'>" + result[count].date_order_placed + "</td>";
					row += "<td style='text-align:center'>" + result[count].date_order_archived + "</td>";

					$('#archive').find('tbody:last').append('<tr>' + row + '</tr>');
					count++;
					
				});

			$('#archive').dialog
			({
				title:  "Archived Orders",
				modal: true,
				height: "auto",
				width: "auto",
				buttons:
				{
					"Close": function()
					{
						$(this).dialog('close');
					}
				}
			});
		},
        error : function(jqXHR, textStatus, errorThrown)
        {
            console.log(textStatus, errorThrown);
        }
    });
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

// <input type="text" id="sell_text_box" style="width: 65px" maxlength="5">

