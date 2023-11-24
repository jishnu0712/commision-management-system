(function ($) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		statusCode: {
			401: function() {
			  window.location.reload();
			  return false;
			}
		  }
	});

	function updateModal(orderId) {
		$.get('orders/show/' + orderId, function (res) {
			// hide loader
			setTimeout(function () {
				hideLoader();
			}, 600);
			if (res.status == 'error') {
				swal("Error", res.msg, "error");
				return false;
			}
			$('#order_info').modal('show');
			$('#order_info').find('.modal-content').html(res);
			//fix plugin
			fixPlugin();
		});
	}
	softnicRms = {
		newClientPage: {
			init: function () {
				var $newClientForm = $('#newClientForm');

				$newClientForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					$this.find('button[type="submit"]').prop('disabled', true);

					var postData = $this.serialize() + '&addClient';
					$.post($this.attr('action'), postData, function (res) {
						var data = JSON.parse(res);
						if (data.status == 'success') {
							window.location.replace('clients.php');
						} else {
							swal("Error", data.msg, "error");
							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});

				});

			}
		},
		newCategoryPage: {
			init: function () {
				var $newClientForm = $('#newCategoryForm');

				$newClientForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					$this.find('button[type="submit"]').prop('disabled', true);

					var postData = $this.serialize() + '&addCategory';
					$.post($this.attr('action'), postData, function (res) {
						var data = JSON.parse(res);
						if (data.status == 'success') {
							window.location.replace('categories.php');
						} else {
							swal("Error", data.msg, "error");
							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});
				});

			}
		},
		updateCategoryPage: {
			init: function () {
				var $newClientForm = $('#updateCategoryForm');
				$newClientForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					$this.find('button[type="submit"]').prop('disabled', true);

					var postData = $this.serialize();
					delete postData.category_id;
					var url = `/admin/category/update/${$('#category_id').val()}`;

					$.ajax({
						type: 'PUT',
						url: url,
						data: postData,
						dataType: 'json',
						success: function (data) {
							if (data.status == 'success') {
								swal("Success", data.msg, "success");
							} else {
								swal("Error", data.msg, "error");
							}
						},
						error: function () {
							swal("Error", "An error occurred while processing the request.", "error");
						},
						complete: function () {
							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});
				});
			}

		},
		categoryPage: {
			init: function () {
				$(document).on('click', '.removeRow', function (e) {
					e.preventDefault();
					var $this = $(this);
					var category_id = $this.attr('data-rowId');

					swal({
						title: "Are you sure?",
						text: "You will not be able to recover.",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes, delete it!",
						closeOnConfirm: true
					}, function () {
						// Send a DELETE request to the category's delete route
						$.ajax({
							url: '/admin/category/delete/' + category_id,
							type: 'DELETE',
							success: function (data) {
								if (data.status == 'success') {
									$this.parent().parent().css('background-color', 'red').hide('slow');
									swal("Success", data.msg, "success");
									$("#categoryList").load(window.location + " #categoryList");
								} else {
									swal("Error", data.msg, "error");
								}
							}
						});
					});
				});
			}

		},
		waiterPage: {
			init: function () {
				$(document).on('click', '.removeRow', function (e) {
					e.preventDefault();
					var $this = $(this);
					var category_id = $this.attr('data-rowId');

					swal({
						title: "Are you sure?",
						text: "You will not be able to recover.",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes, delete it!",
						closeOnConfirm: true
					}, function () {
						// Send a DELETE request to the category's delete route
						$.ajax({
							url: '/admin/waiter/delete/' + category_id,
							type: 'DELETE',
							success: function (data) {
								if (data.status == 'success') {
									$this.parent().parent().css('background-color', 'red').hide('slow');
									swal("Success", data.msg, "success");
									$("#categoryList").load(window.location + " #categoryList");
								} else {
									swal("Error", data.msg, "error");
								}
							}
						});
					});
				});
			}

		},
		addItemPage: {
			init: function () {
				var $addItemForm = $('#addItemForm');

				// remove category
				$addItemForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);

					var postData = new FormData(this);
					postData.append('addItem', "");

					$.ajax({
						type: 'POST',
						url: $this.attr('action'),
						data: postData,
						dataType: 'json',
						contentType: false,
						cache: false,
						processData: false,
						beforeSend: function () {
							$this.find('button[type="submit"]').prop('disabled', true);
						},
						success: function (data) {

							if (data.status == 'success') {
								window.location.replace("item_list.php");
							} else {
								swal("Error", data.msg, "error");
							}

							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});

				});

			}
		},
		blockedCustomer: {
			init: function () {
				$(document).on('click', '.unBlockBtn', function (e) {
					var $this = $(this);
					var blocked_id = $this.attr('blocked_id');
					$.post('/admin/unblock/customers', { blocked_id: blocked_id }, function (res) {
						var data = res;
						if (data.status == 'success') {
							$this.parent().parent().css('background', 'red').fadeOut();
							swal("Success", data.msg, "success");
						} else {
							swal("Error", data.msg, "error");
						}
					});
				});
			}
		},
		itemListPage: {
			init: function () {
				$(document).on('change', '.item_status', function (e) {
					e.preventDefault();
					var $this = $(this);
					var setStatus = this.checked ? 1 : 0;
					var url = `menu/statusupdate/${$this.attr('data-rowId')}`;

					$.ajax({
						url: url,
						type: 'PUT', // Use PUT method
						data: {
							status: setStatus,
						},
						success: function (data) {
							if (data.status === 'success') {
								swal('Success', data.msg, 'success');
							} else {
								swal('Error', data.msg, 'error');
							}
						},
						error: function () {
							swal('Error', 'An error occurred.', 'error');
						},
					});
				});


				/*remove item*/
				var $removeRow = $('.removeRow');
				$removeRow.on('click', function (e) {
					e.preventDefault();
					var $this = $(this);
					var postData = {
						removeItem: "",

						rowId: $this.attr('data-rowId')
					}

					swal({
						title: "Are you sure?",
						text: "You will not be able to recover.",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes, delete it!",
						closeOnConfirm: true
					}, function () {
						$.post('action/action.user.php', postData, function (res) {
							var data = JSON.parse(res);
							if (data.status == 'success') {
								$this.parent().parent().css('background-color', 'red').hide('slow');
								swal("Success", data.msg, "success");
							} else {
								swal("Error", data.msg, "error");
							}

						});
					});

				});
				/* ./ remove item ./ */

			}
		},
		editItemPage: {
			init: function () {
				var $updateItemForm = $('#updateItemForm');
				$updateItemForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					var postData = new FormData(this);
					$.ajax({
						type: 'POST',
						url: $this.attr('action'),
						data: postData,
						dataType: 'json',
						contentType: false,
						cache: false,
						processData: false,
						beforeSend: function () {
							$this.find('button[type="submit"]').prop('disabled', true);
						},
						success: function (data) {

							if (data.status == 'success') {
								swal("Success", data.msg, "success");
								setTimeout(function () {
									location.reload();
								}, 1000);
							} else {
								swal("Error", data.msg, "error");
							}

							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});

				});
				$('#image').change(function () {
					var input = this;
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#imagePreview').attr('src', e.target.result);
						};
						reader.readAsDataURL(input.files[0]);
					}
				});
			}
		},
		addTablePage: {
			init: function () {
				var $addTableForm = $('#addTableForm');

				// remove category
				$addTableForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);

					var postData = $this.serialize() + '&addTable';
					$this.find('button[type="submit"]').prop('disabled', true).text('Loading...');
					$.post($this.attr('action'), postData, function (res) {
						var data = JSON.parse(res);
						if (data.status == 'success') {
							window.location.replace('tables.php');
						} else {
							swal("Error", data.msg, "error");
							$this.find('button[type="submit"]').prop('disabled', false).text('Add Table');
						}
					});

				});

			}
		},
		tablesPage: {
			init: function () {

				/*remove item*/
				// $(document).on('click', '.removeRow', function (e) {
				// 	e.preventDefault();
				// 	var $this = $(this);
				// 	var tableId = $this.attr('data-rowId');

				// 	swal({
				// 		title: "Are you sure?",
				// 		text: "You will not be able to recover.",
				// 		type: "warning",
				// 		showCancelButton: true,
				// 		confirmButtonColor: "#DD6B55",
				// 		confirmButtonText: "Yes, delete it!",
				// 		closeOnConfirm: true
				// 	}, function () {
				// 		// Send a DELETE request to the table's delete route
				// 		$.ajax({
				// 			url: 'table/delete/' + tableId,
				// 			type: 'DELETE',
				// 			success: function (data) {
				// 				if (data.status == 'success') {
				// 					$this.parent().parent().css('background-color', 'red').hide('slow');
				// 					swal("Success", data.msg, "success");
				// 					$("#tableList").load(window.location + " #tableList");
				// 				} else {
				// 					swal("Error", data.msg, "error");
				// 				}
				// 			}
				// 		});
				// 	});
				// });

				/* ./ remove item ./ */

			}
		},
		ordersPage: {
			init: function () {
				/*view order*/
				var $orderModal = $('#order_info');
				$(document).on('click', '.viewOrder', function (e) {
					// hide loader
					setTimeout(function () {
						hideLoader();
					}, 600);
					e.preventDefault();
					var $this = $(this);
					var orderId = $this.attr('data-rowId');
					// show loader
					showLoader('Loading order...');
					$.get('orders/show/' + orderId, function (res) {
						if (res.status == 'error') {
							swal("Error", res.msg, "error");
							return false;
						}
						$orderModal.modal('show');
						$orderModal.find('.modal-content').html(res);
						//fix plugin
						fixPlugin();
					});

				});
				/* ./ view order ./ */


				/*add discount*/
				$(document).on('submit', '#discountForm', function (e) {
					e.preventDefault();
					var $orderModal = $('#order_info');

					var postData = $(this).serialize();

					showLoader('Updating discount...');
					$.post('orders/discount', postData, function (res) {
						setTimeout(function () {
							hideLoader();
						}, 600);
						if (res.status == 'error') {
							swal("Error", res.msg, "error");
							return false;
						}
						$orderModal.modal('show');
						$orderModal.find('.modal-content').html(res);
						//fix plugin
						fixPlugin();

						// hide loader

					});


				});
				/*./add discount./*/


				/*remove discount*/
				$(document).on('click', '.romoveDiscountFromOrder', function (e) {
					e.preventDefault();
					var $this = $(this);
					var orderId = $this.attr('data-rowId');

					showLoader('Removing discount...');
					$.post('orders/discount/remove', { orderId: orderId }, function (res) {
						// hide loader
						setTimeout(function () {
							hideLoader();
						}, 600);
						var data = res;
						/*update order modal*/
						if (data.status == 'error') {
							swal("Error", data.msg, "error");
							return false;
						}
						$orderModal.modal('show');
						$orderModal.find('.modal-content').html(data);
						//fix plugin
						fixPlugin();
					});

				});
				/* ./ remove discount ./ */


				/*accept order*/
				$(document).on('click', '.placeOrderBtn', function (e) {
					e.preventDefault();
					var $this = $(this);
					var orderId = $this.attr('data-rowId');
					// showLoader('Please wait...');
					$.post('orders/accept', { orderId: orderId }, function (res) {
						var data = res;
						if (data.status == 'success') {

							/*update order modal*/
							updateModal(orderId);
							var order_id = data.order_id;

							//remove blink
							$('#order_no_' + order_id).removeClass('blink_order');
							$('#order_no_' + order_id).find('.bs-placeholder .filter-option').text('In Process');
							$('#order_no_' + order_id).find('.bs-placeholder').parent().removeClass('filter_option_pending').addClass('filter_option_preparation');

							//fix plugin
							fixPlugin();

							// hide loader
							hideLoader();

							//show success
							swal("Success", data.msg, "success");


						} else {
							// hide loader
							hideLoader();
							swal("Error", data.msg, "error");
						}
					});



				});
				/* ./accept order./ */


				/*complete order*/
				$(document).on('click', '.completeOrder', function (e) {
					e.preventDefault();
					var $this = $(this);
					var pay_type = $("#pay_type :selected").val();
					if(pay_type == ''){
						swal("Error", 'Please select payment type!', "error");
						return false;
					}
					var orderId = $this.attr('data-rowId');
					var thirdparty = $this.attr('data-3rdparty');
					var submit_form = true;
					var order_amount = null;

					if (thirdparty == 1) {
						order_amount = $('#order_info').find('input[name="total_amount"]').val();
						if (order_amount == '') {
							submit_form = false;
							swal("Error", 'Order amount should not be empty!', "error");
						}
					}

					if (submit_form) {
						showLoader('Order completing, wait...');
						$.post('orders/complete', { orderId: orderId, order_amount: order_amount, pay_type: pay_type }, function (res) {
							var data = res;
							if (data.status == 'success') {

								/*update order modal*/
								$.get('orders/show/' + orderId, function (res) {
									// hide loader
									setTimeout(function () {
										hideLoader();
									}, 600);
									if (res.status == 'error') {
										swal("Error", res.msg, "error");
										return false;
									}
									$orderModal.modal('show');
									$orderModal.find('.modal-content').html(res);
									//fix plugin
									fixPlugin();
								});
								$orderModal.find('.modal-content').html(res);

								//remove blink
								$('#order_no_' + res.order_id).removeClass('blink_order');
								$('#order_no_' + res.order_id).find('.bs-placeholder .filter-option').text('Completed');
								$('#order_no_' + res.order_id).find('.bs-placeholder').parent().removeClass('filter_option_preparation').addClass('filter_option_delivered');

								//fix plugin
								fixPlugin();

								// hide loader
								hideLoader();

								//show success
								swal("Success", data.msg, "success");

							} else {
								// hide loader
								hideLoader();
								swal("Error", data.msg, "error");
							}
						});
					}

				});
				/* ./complete order./ */


				/*cancel order*/
				$(document).on('click', '.cancelOrderBtn', function (e) {
					e.preventDefault();
					var $this = $(this);
					var orderId = $this.attr('data-rowId');

					swal({
						title: "Are you sure?",
						text: "You will not be able to recover.",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes, cancel order!",
						closeOnConfirm: true
					}, function () {
						showLoader('Please wait...');
						$.post('orders/cancel', { cancelOrder: '', orderId: orderId }, function (res) {
							var data = res;
							if (data.status == 'success') {

								/*update order modal*/
								updateModal(orderId);

								//remove blink
								$('#order_no_' + data.order_id).removeClass('blink_order');
								$('#order_no_' + data.order_id).find('.bs-placeholder .filter-option').text('Cancelled');
								$('#order_no_' + data.order_id).find('.bs-placeholder').parent().removeClass('filter_option_preparation').addClass('filter_option_cancelled');

								//fix plugin
								fixPlugin();

								// hide loader
								hideLoader();

								//show success
								swal("Success", data.msg, "success");

							} else {
								// hide loader
								hideLoader();
								swal("Error", data.msg, "error");
							}
						});
					});

				});
				/* ./calcel order./ */

				/*update order quantity*/
				$(document).on('submit', '#updateCartForm', function (e) {
					e.preventDefault();
					var $this = $(this);


					showLoader('Please wait...');
					$.post('orders/item/update', $this.serialize(), function (res) {
						// hide loader
						setTimeout(function () {
							hideLoader();
						}, 600);
						var data = res;
						if (data.status == 'error') {
							swal("Error", data.msg, "error");
							return false;
						}
						$orderModal.modal('show');
						$orderModal.find('.modal-content').html(data);
						//fix plugin
						fixPlugin();
					});
				});
				// SELECT VALUE
				$(document).on('click', ".updateCustomerDetails", function () {
					$(this).select();
				});
				/*update order quantity*/
				$(document).on('blur', '.updateCustomerDetails', function (e) {
					e.preventDefault();
					var $this = $(this);
					var name = $this.attr('name');
					var value = $this.val();
					var order_id = $(document).find('#updateOrderId').val();

					// showLoader('Updating customer...');
					$.post('orders/update/userinfo', { name: name, value: value, orderId: order_id }, function (res) {
						// hide loader
						setTimeout(function () {
							hideLoader();
						}, 600);
						var data = res;
						if (data.status == 'error') {
							swal("Error", data.msg, "error");
							return false;
						}

						$('#order_no_' + data.order_id).find(name == 'fullname' ? '.fullname' : '.phone').text(value);
						//fix plugin
						// fixPlugin();
					});
				});
				/*./update order quantity./*/

				// BLOCK CUSTOMER IP ADDRESS
				$(document).on('click', '.blockIpAddress', function (e) {
					e.preventDefault();
					var $this = $(this);
					var type = $this.attr('type');
					var order_id = $(document).find('.cancelOrderBtn').attr('data-rowid');

					// showLoader('Blocking IP address...');
					$.post('orders/block/ip', { orderId: order_id, type: type }, function (res) {
						// hide loader
						setTimeout(function () {
							hideLoader();
						}, 600);
						var data = res;
						if (data.status == 'error') {
							swal("Error", data.msg, "error");
							return false;
						} else {
							$this.removeClass(type == 'block' ? 'btn-danger' : 'btn-success').addClass(type == 'block' ? 'btn-success' : 'btn-danger').attr('type', type == 'block' ? 'unblock' : 'block').text(type == 'block' ? 'Unblock' : 'Block');
							swal("Success", data.msg, "success");
						}
						//fix plugin
						// fixPlugin();
					});
				});

				// REMOVE ITEM
				$(document).on('click', '.removeProductFromOrder', function (e) {
					e.preventDefault();
					var $this = $(this);
					var item_id = $this.attr('data-rowid');

					swal({
						title: "Are you sure?",
						text: "You will not be able to recover.",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes, delete it!",
						closeOnConfirm: true
					}, function () {
						// Send a DELETE request to the category's delete route
						showLoader('Deleting item...');
						$.ajax({
							url: 'orders/remove/item',
							type: 'POST',
							data: { item_id: item_id },
							success: function (res) {
								setTimeout(function () {
									hideLoader();
								}, 600);
								if (res.status == 'error') {
									swal("Error", res.msg, "error");
									return false;
								}
								$orderModal.modal('show');
								$orderModal.find('.modal-content').html(res);
								//fix plugin
								fixPlugin();
							}
						});
					});
				});
				/*item repeter*/
				$(document).on('click', '#addProToTbL', function (e) {
					var $item_element = $(document).find('.item_repeter_content').first().clone();
					$('.item_repeter_container').append($item_element);
					$item_element.find('.select2-container').remove();
					$item_element.find('input').val('');
					$item_element.find('input[name="qty[]"]').val(1);
					$item_element.find('button').removeAttr('id').addClass('remove_repeter_item');
					$item_element.find('button i').removeClass('fa-plus').addClass('fa-minus');
					$item_element.find('button').removeClass('btn-primary').addClass('btn-danger');
					$item_element.find('.action_name').text('Remove');
					$('.select2').select2();
				});

				$(document).on('click', '.remove_repeter_item', function (e) {
					$(this).parent().parent().parent().remove();
				});
				/*./item repeter./*/

				/*add more items*/
				$(document).on('submit', '#adminAddonItemsForm', function (e) {
					// hide loader
					setTimeout(function () {
						hideLoader();
					}, 600);
					e.preventDefault();
					var $this = $(this);

					showLoader('Please wait...');
					$.post('orders/addon', $this.serialize(), function (res) {
						var data = res;

						if (data.status == 'error') {
							swal("Error", data.msg, "error");
							return false;
						}
						$orderModal.modal('show');
						$orderModal.find('.modal-content').html(data);
						//fix plugin
						fixPlugin();
					});


				});
				/* ./add more items ./*/

				/* open new order modal*/
				$('#createNewOrderBtn').on('click', function (e) {
					$('#modal_create_new_order').modal('show');
				});
				/* ./open new order modal./ */

				/*create new order*/
				$('#create_new_order_form').on('submit', function (e) {
					var $this = $(this);
					e.preventDefault();

					// showLoader('Please wait...');
					$.post('orders/create', $this.serialize(), function (res) {
						var data = res;

						if (data.status == 'success') {
							//show success
							swal("Success", data.msg, "success");
							window.location.reload();

						} else {
							// hide loader
							hideLoader();
							swal("Error", data.msg, "error");
						}
					});

				});

				/* ./create new order ./ */

                // SEND WHATSAPP INVOICE
                $(document).on("click", ".sendWhatsappInvoice", function(e) {
                    e.preventDefault();
                    let order_id = $('input[name="order_id"]').val();
                    showLoader('Sending invoice on WhatsApp...');
                    $.get(`wpinvoice/${order_id}`, (data, status) => {
                        hideLoader();
                        if (!data.error) {
                            swal('Success', 'Invoice sent successfully.', 'success');
                        } else {
                            swal('Error', data.message, 'error');
                        }
                    })
                });

                // SEND ORDER INFO
                $(document).on("click", "#sendOrderInfoBtn", function(e) {
                    e.preventDefault();
                    let order_id = $('input[name="order_id"]').val();
                    let waiter_id = $('#waiter_id option:selected').val();
                    if(waiter_id == ''){
                        swal('Error', 'Please select a waiter!', 'error');
                        return false;
                    }

                    showLoader('Sending order info...');
                    $.post(`waiter/send`, {order_id : order_id, waiter_id : waiter_id}, (data, status) => {
                        hideLoader();
                        if (!data.error) {
                            swal('Success', 'KOT sent successfully.', 'success');
                        } else {
                            swal('Error', data.message, 'error');
                        }
                    })
                });

			}
		},
		clientPageUser: {
			init: function () {
				$('#newTransactionBtn').on('click', function (e) {
					$('#modal_new_transaction').modal('show');
				});


				var $new_transactin_form = $('#new_transactin_form');

				$new_transactin_form.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					$this.find('button[type="submit"]').prop('disabled', true);

					var postData = $this.serialize() + '&addNewTransaction=';
					$.post($this.attr('action'), postData, function (res) {
						var data = JSON.parse(res);
						if (data.status == 'success') {
							location.reload(false);
						} else {
							swal("Error", data.msg, "error");
							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});

				});


			}
		},
		/*settings*/
		settingsPage: {
			init: function () {
				var $updateSettingsForm = $('#updateSettingsForm');
				$updateSettingsForm.on('submit', function (e) {
					e.preventDefault();
					var $this = $(this);
					$this.find('button[type="submit"]').prop('disabled', true);

					var postData = $this.serialize() + '&updateSettings=';
					$.post($this.attr('action'), postData, function (res) {
						var data = JSON.parse(res);
						if (data.status == 'success') {
							swal("Success", data.msg, "success");
							setTimeout(function () {
								location.reload(false);
							}, 1000);
						} else {
							swal("Error", data.msg, "error");
							$this.find('button[type="submit"]').prop('disabled', false);
						}
					});

				});


			}
		},

	}
})($);