define(
	['jquery', 'myResult', 'myValidator', 'datetimepicker'],
	function($, myResult, myValidator) {
		var myTimePicker = function(page) {
			var _input = page.find('input.timepicker')
			_input.datetimepicker({
				format: 'LT',
				format: 'HH:mm'
			})
		}

		var myResultConfig = {
			enabled: true,
			forms: {
				'form-add': {
					//成功
					success: {
						toast: '添加成功',
						route: 'reload',
					},

					//失败
					error: {
						toast: '操作失败',
						route: 'reload',
					},
				}
			}
		}

		var myValidatorConfig = {
			enabled: true,
			forms: {
				'form-add': {
					fields: {
						name: {
							validators: {

								notEmpty: {
									message: '请输入名称',
								},

								stringLength: {
									message: '最长36个字符',
									max: 121,
								},

								remote: {
									url: '/api/shiftType/validName',
									type: 'POST', //以post的方式发生信息
									data: function(validator) {
										return {
											workyard_id: validator.getFieldElements('workyard_id').val()
										};
									},
									message: '名称已存在',
								},
							}
						},
					},
				},
			},

		}

		return {
			init: function(pageName, page) {
				myTimePicker(page)
				myResult.init(page, myResultConfig)
				myValidator.init(page, myValidatorConfig)
			}
		}
	})