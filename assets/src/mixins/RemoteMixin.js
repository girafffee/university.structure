export default {
	methods: {
		getObjectProperty( prop, initial, ifEmpty ) {
			if ( !prop ) {
				return initial;
			}

			prop = prop.match( /\w+(\/\w+)*/gi )[ 0 ];
			let props = prop.split( '/' );

			function inside( source, i = 0 ) {
				let current = source[ props[ i ] ];

				if ( props[ i + 1 ] && current ) {
					return inside( current, i + 1 );
				}

				return current ? current : ifEmpty;
			}

			return inside( initial );
		},
		config( prop, ifEmpty = null ) {
			return this.getObjectProperty( prop, window.pageConfig, ifEmpty );
		},
		global( prop, ifEmpty = null ) {
			return this.getObjectProperty( prop, window.globalConfig, ifEmpty );
		}
	}
}