# Helper Functions


# Determines whether the current device is mobile
$.isMobile = ->
	devices          = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i
	responsive_width = 768

	return devices.test(navigator.userAgent) && $(window).width() <= responsive_width

