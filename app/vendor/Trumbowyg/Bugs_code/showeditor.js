			setTimeout(function() {
				$('textarea').trumbowyg({
					btns: [
						['viewHTML'],
						['undo', 'redo'], // Only supported in Blink browsers
						['formatting'],
						['strong', 'em', 'del'],
						['foreColor', 'backColor'],
						['superscript', 'subscript'],
						['link'],
						['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
						['unorderedList', 'orderedList'],
						['horizontalRule'],
						['removeformat'],
						['fullscreen']
					],
					removeformatPasted: true,
					resetCss: true,
				});
			}, 1000);		
