( function( d, mw, $ ){

	function _initFlyout( $elem ) {
		var data = $elem.data( 'bs-userinfo' );

		var $container = $( '<div></div>' );
		var $content = $( '<div class="bs-userinfo-container"></div>' );

		var tplUserImage = mw.template.get(
			'ext.bluespice.userinfo.templates',
			'BlueSpiceFoundation.UserImage.mustache'
		);

		var tpl = mw.template.get(
			'ext.bluespice.userinfo.templates',
			'BlueSpiceUserInfo.UserInfo.Default.mustache'
		);

		var $userImage = tplUserImage.render( {
			'widht': 50,
			'height': 50,
			'username': data.username,
			'imagesrc': mw.config.get( 'wgScriptPath' ) + '/dynamic_file.php?module=userprofileimage&username=' + data.username + '&width=70&height=70',
			'anchorhref': mw.util.getUrl( 'User:' + data.username ),
			'imagealt': data.meta.name.value,
			'imagetitle': data.meta.name.value
		} );

		var out = '';
		$userImage.each( function( i, e ) {
			if( $( e ) && $( e ).prop( 'outerHTML' ) ) {
				out += $( e ).prop( 'outerHTML' );
			}
		});

		var contentdata = '';
		var tplData = {
			'userimage': out,
			'content': [],
			'title': [],
			'subtitle': []
		};
		for( var i in data.meta ) {
			if( !data.meta[i].value || data.meta[i].value === '' ) {
				continue;
			}
			tplData[data.meta[i].name] = data.meta[i].value;
			if( data.meta[i].title ) {
				tplData.title.push( data.meta[i] );
				continue;
			}
			if( data.meta[i].subtitle ) {
				tplData.subtitle.push( data.meta[i] );
				continue;
			}

			tplData.content.push( data.meta[i] );
		}

		$( d ).trigger( 'BSUserInfoFlyoutBeforeTemplateDataRender', [ tplData, $container] );

		$content.append( $( tpl.render( tplData ) ) );

		$container.append( $content );

		var cfg = {
			target: $elem[0],
			cls: 'bs-userinfo-tooltip',
			html: $container.html(),
			anchorToTarget: true,
			layout: 'anchor',
			defaultAlign: 'bl-tr',
			renderTo: $elem[0],
			listeners: {
				'show': function( e ) {
					e.updateLayout();
				}
			}
		};

		var tooltip = new Ext.tip.ToolTip( cfg );
		tooltip.show();

		$elem.data( 'userinfo-flyout-created', true );
	}

	$( d ).on( 'mouseover', ".content-wrapper [data-bs-userinfo]" , function( event ) {
		var $elem = $( this );
		if( $elem.data( 'userinfo-flyout-created' ) ) {
			return;
		}

		mw.loader.using( 'ext.bluespice.extjs' ).done( function() {
			Ext.onReady( function() {
				_initFlyout( $elem );
			} );
		});
	});

}( document, mediaWiki, jQuery ) );