/*
	A JavaScript plugin for lazy-loading responsive Google Adsense ads.
	-
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

;( function( root, factory )
{
	var pluginName = 'adsenseLoader';
	if( typeof define === 'function' && define.amd ) define([], factory( pluginName ));
	else if( typeof exports === 'object' ) module.exports = factory( pluginName );
	else root[ pluginName ] = factory( pluginName );

}( this, function( pluginName )
{
	//'use strict';

	var scriptUrl		= '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
		scriptLoaded	= false,
		throttleTO		= 250,

		defaultOpts =
		{
			laziness:	1,
			onLoad:		false
		},

		extendObj = function( defaults, options )
		{
			var prop, extended = {};
			for( prop in defaults )
				if( Object.prototype.hasOwnProperty.call( defaults, prop ))
					extended[ prop ] = defaults[ prop ];

			for( prop in options )
				if( Object.prototype.hasOwnProperty.call( options, prop ))
					extended[ prop ] = options[ prop ];

			return extended;
		},

		addClass = function( el, className )
		{
			if( el.classList )	el.classList.add( className );
			else				el.className += ' ' + className;
		},

		getOffset = function( el )
		{
			var rect = el.getBoundingClientRect();
			return { top: rect.top + document.body.scrollTop, left: rect.left + document.body.scrollLeft };
		},

		loadScr = function( url, callback )
		{
			var s	= document.createElement( 'script' );
			s.src	= url;
			s.async	= true;
			s.onerror=function(){console.error('adsOk:', window.adsOk=-1);};
			s.addEventListener( 'load', function()
			{
				s.parentNode.removeChild( s );
				if( typeof callback === 'function' )
					callback();
			});
			document.body.appendChild( s );
			console.log('ADS:loadScr',url);
		},

		throttle = function(a,b){var c,d;return function(){var e=this,f=arguments,g=+new Date;c&&g<c+a?(clearTimeout(d),d=setTimeout(function(){c=g,b.apply(e,f)},a)):(c=g,b.apply(e,f))}},


		adsToLoad	= [],
		adsLoaded	= [],
		adsPending	= [],

		loadAd = function( ad )
		{
			( adsbygoogle = window.adsbygoogle || []).push({});

			var onLoadFn = ad._adsenseLoaderData.options.onLoad;
			if( typeof onLoadFn === 'function' )
			{
				var f=ad.querySelector( 'iframe' );
				if(f) {
					f.addEventListener('load', function () {
						window.adsOk = 1;
						onLoadFn(ad);
					});
				}else{
					console.error('Реклама не загрузилась в ',ad);
				}
			}
		},
		initAds = function()
		{
			if( !adsToLoad.length ) return true;

			var winScroll = window.pageYOffset,
				winHeight = window.innerHeight;

			adsToLoad.forEach( function( ad )
			{
				var offset	 = getOffset( ad ).top,
					laziness = ad._adsenseLoaderData.options.laziness + 1;

				// if the element is too far below || too far above
				if( offset - winScroll > winHeight * laziness || winScroll - offset - ad.offsetHeight - ( winHeight * laziness ) > 0 )
					return true;

				adsToLoad					= removeAdFromList( adsToLoad, ad );
				ad._adsenseLoaderData.width	= getAdWidth( ad );
				addClass( ad.children[ 0 ], 'adsbygoogle' );
				adsLoaded.push( ad );

				if( typeof adsbygoogle !== 'undefined' ) loadAd( ad );
				else adsPending.push( ad );

				if( !scriptLoaded )
				{
					scriptLoaded = true;
					loadScr( scriptUrl, function()
					{
						adsPending.forEach( loadAd );
					});
				}
			});
		},
		resizeAds = function()
		{
			if( !adsLoaded.length ) return true;

			var anyNew = false;
			adsLoaded.forEach( function( ad )
			{
				if( ad._adsenseLoaderData.width != getAdWidth( ad ))
				{
					anyNew			= true;
					adsLoaded		= removeAdFromList( adsLoaded, ad );
					ad.innerHTML	= ad._adsenseLoaderData.originalHTML;
					adsToLoad.push( ad );
				}
			});
			if( anyNew ) initAds();
		},
		getAdWidth = function( ad )
		{
			return parseInt( window.getComputedStyle( ad, ':before' ).getPropertyValue( 'content' ).slice( 1, -1 ) || 9999 );
		},
		removeAdFromList = function( list, element )
		{
			return list.filter( function( entry )
			{
				return entry !== element;
			});
		},
		normalizeAdElement = function( ad, options )
		{
			ad._adsenseLoaderData =
			{
				originalHTML:	ad.innerHTML,
				options:		options
			};
			ad.adsenseLoader = function( method )
			{
				if( method == 'destroy' )
				{
					adsToLoad	= removeAdFromList( adsToLoad, ad );
					adsLoaded	= removeAdFromList( adsLoaded, ad );
					adsPending	= removeAdFromList( adsLoaded, ad );
					ad.innerHTML = ad._adsenseLoaderData.originalHTML;
				}
			};
			return ad;
		};


	window.addEventListener( 'scroll', throttle( throttleTO, initAds ));
	window.addEventListener( 'resize', throttle( throttleTO, initAds ));
	window.addEventListener( 'resize', throttle( throttleTO, resizeAds ));


	function Plugin( elements, options )
	{
		if( typeof elements === 'string' )					elements = document.querySelectorAll( elements );
		else if( typeof elements.length === 'undefined' )	elements = [ elements ];

		options = extendObj( defaultOpts, options );

		[].forEach.call( elements, function( entry )
		{
			entry = normalizeAdElement( entry, options );
			adsToLoad.push( entry );
		});

		this.elements = elements;

		initAds();
	}

	Plugin.prototype =
	{
		destroy: function()
		{
			this.elements.forEach( function( entry )
			{
				entry.adsenseLoader( 'destroy' );
			});
		}
	};

	window.adsenseLoaderConfig = function( options )
	{
		if( typeof options.scriptUrl !== 'undefined' )
			scriptUrl = options.scriptUrl;

		if( typeof options.throttle !== 'undefined' )
			throttleTO = options.throttle;
	};

	return Plugin;
}));

/*function antiadblock(){
	var s=['iframe[style="visibility: visible; position: fixed !important; display: block !important; border: 0px !important; -webkit-box-shadow: rgba(0, 0, 0, 0.498039) 5px 5px 20px; z-index: 2147483647; left: 50px; top: 50px; width: 416px; height: 195px; opacity: 0.7;"]',
		'iframe[style="visibility: visible; position: fixed !important; display: block !important; border: 0px !important; -webkit-box-shadow: rgba(0, 0, 0, 0.498039) 5px 5px 20px; z-index: 2147483647; left: 50px; top: 50px; width: 416px; height: 195px;"]',
		'iframe[id="adguard-assistant-dialog"]',
		'iframe[class="sg_ignore adg-view-important"]',
		'div[class="__adblockplus__overlay"]',
		'div[class="sg_border"]',
		'div[class="sg_border sg_bottom_border"]'];
	s.forEach(function( ad ){
		var u=document.querySelectorAll(ad), i, o;
		for(i=0;i< u.length;i++){
			o=u[i];
			o.parentNode.removeChild(o);
		}

	});
	setTimeout(function(){antiadblock();},250);
}
console.info('Скрипт Anti-AdBlock сейчас будет запущен...');
antiadblock();
console.info('Скрипт Anti-AdBlock работает.');
*/
