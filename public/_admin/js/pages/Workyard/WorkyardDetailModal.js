define(
	['jquery', 'myGaodemap'], 
	function($, myGaodemap) {
	var myGaodemapConfig = {
			container_id: 'map_container',
			callback: function() {
				var mapObj = arguments[0]
				var addressPath = $('#map_container_address_path').text()
				addressPath = JSON.parse(addressPath)
				mapObj.plugin(['AMap.PolyEditor'], function() {
					var polygon = new AMap.Polygon({
						map: mapObj,
						path: addressPath,
						isOutline: true,
						borderWeight: 3,
						strokeColor: "#FF33FF",
						strokeWeight: 6,
						strokeOpacity: 0.2,
						fillOpacity: 0.4,
						// 线样式还支持 'dashed'
						fillColor: '#1791fc',
						zIndex: 50,
					})
					
					// 缩放地图到合适的视野级别
					mapObj.setFitView([polygon])
				})
			}
		}
	return {
		init: function(pageName, page) {
			myGaodemap.init(page, myGaodemapConfig)
		}
	}
})