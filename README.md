# Secure Headers

[![Build Status](https://travis-ci.org/miya0001/secure-headers.svg?branch=master)](https://travis-ci.org/miya0001/secure-headers)

A WordPress plugin which sends HTTP security heades.

## Default Headers

```
strict-transport-security:max-age=31536000; includeSubDomains; preload
x-content-type-options:nosniff
x-frame-options:DENY
x-xss-protection:1; mode=block
```

## Customization

### X-Frame-Options

```
add_filter( 'secure_header_x_frame_options', function() {
	return 'DENY';
} );
```

### Strict-Transport-Security

```
add_filter( 'secure_header_strict_transport_security', function() {
	return 'max-age=31536000; includeSubDomains; preload';
} );
```

### X-XSS-Protection

```
add_filter( 'secure_header_x_xss_protection', function() {
	return '1; mode=block';
} );
```

### X-Content-Type-Options

```
add_filter( 'secure_header_x_content_type_options', function() {
	return 'nosniff';
} );
```
