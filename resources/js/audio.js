( function( $ ) {
	var audio = document.createElement( 'audio' ),
		html = document.documentElement,
		key = '',
		support = {
			mp3: !! ( audio.canPlayType && audio.canPlayType( 'audio/mpeg;' ).replace( /no/, '' ) ),
			ogg: !! ( audio.canPlayType && audio.canPlayType( 'audio/ogg; codecs="vorbis"' ).replace( /no/, '' ) ),
			wav: !! ( audio.canPlayType && audio.canPlayType( 'audio/wav; codecs="1"' ).replace( /no/, '' ) )
		};

	for ( var key in support ) {
		if ( support.hasOwnProperty( key ) && support[key] === true ) {
			html.className += ' dusktodawn-' + key;
		}
	}
} ) ();
