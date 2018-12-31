<!-- START_{{$route['id']}} -->
@if($route['title'] != '')## {{ $route['title']}}
@else## {{$route['uri']}}@endif
@if($route['authenticated'])
<span style="padding: 5px 9px;white-space: nowrap;color: #ffffff;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;background-color: #7204c5;">Headers 必须附带 Authorization</span>
@endif{{--Requires authentication--}}
@if($route['description'])

{!! $route['description'] !!}
@endif

> Example request:

```bash
curl -X {{$route['methods'][0]}} {{$route['methods'][0] == 'GET' ? '-G ' : ''}}"{{ rtrim(config('apidoc.docs_url') !== false ? config('apidoc.docs_url') : config('app.url'), '/') }}/{{ ltrim($route['uri'], '/') }}" @if(count($route['headers']))\
@foreach($route['headers'] as $header => $value)
    -H "{{$header}}: {{$value}}"@if(! ($loop->last) || ($loop->last && count($route['bodyParameters']))) \
@endif
@endforeach
@endif
@foreach($route['bodyParameters'] as $attribute => $parameter)
    -d "{{$attribute}}"="{{$parameter['value'] === false ? "false" : $parameter['value']}}" @if(! ($loop->last))\
@endif
@endforeach

```

```javascript
const url = new URL("{{ rtrim(config('apidoc.docs_url') !== false ? config('apidoc.docs_url') : config('app.url'), '/') }}/{{ ltrim($route['uri'], '/') }}");
@if(count($route['queryParameters']))

    let params = {
    @foreach($route['queryParameters'] as $attribute => $parameter)
        "{{ $attribute }}": "{{ $parameter['value'] }}",
    @endforeach
    };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
@endif

let headers = {
@foreach($route['headers'] as $header => $value)
    "{{$header}}": "{{$value}}",
@endforeach
@if(config('apidoc.router') === 'Dingo' && config('api.strict')){{--201881231增加router如果是dingo 并且dingo开启了严格模式--}}
    @if(!array_key_exists('Accept', $route['headers'])){{--默认增加Accept--}}
    "Accept": {{ config('apidoc.default_accept','application/json') }},
    @endif
@endif
@if(config('apidoc.default_content_type') !== false){{--20181231默认增加default_content_type配置项，可默认显示或不显示--}}
    @if(!array_key_exists('Content-Type', $route['headers']))
        "Content-Type": {{ config('apidoc.default_content_type','application/json') }},
    @endif
@endif
}
@if(count($route['bodyParameters']))

let body = JSON.stringify({
@foreach($route['bodyParameters'] as $attribute => $parameter)
    "{{ $attribute }}": "{{ $parameter['value'] }}",
@endforeach
})
@endif

fetch(url, {
    method: "{{$route['methods'][0]}}",
    headers: headers,
@if(count($route['bodyParameters']))
    body: body
@endif
})
    .then(response => response.json())
    .then(json => console.log(json));
```

@if(in_array('GET',$route['methods']) || (isset($route['showresponse']) && $route['showresponse']))
@if(is_array($route['response']))
@foreach($route['response'] as $response)
> Example response ({{$response['status']}}):

```json
@if(is_object($response['content']) || is_array($response['content']))
{!! json_encode($response['content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@else
{!! json_encode(json_decode($response['content']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@endif
```
@endforeach
@else
> Example response:

```json
@if(is_object($route['response']) || is_array($route['response']))
{!! json_encode($route['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@else
{!! json_encode(json_decode($route['response']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@endif
```
@endif
@endif

### HTTP Request
@foreach($route['methods'] as $method)
<span style="padding: 1px 5px;white-space: nowrap;color: #ffffff;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;background-color: #7204c5;">{{$method}}</span>
` {{ rtrim(config('apidoc.docs_url') !== false ? config('apidoc.docs_url') : config('app.url'), '/') }}/{{ ltrim($route['uri'], '/') }}`

@endforeach
@if(count($route['bodyParameters']))
#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
@foreach($route['bodyParameters'] as $attribute => $parameter)
    {{$attribute}} | {{$parameter['type']}} | @if($parameter['required']) required @else optional @endif | {!! $parameter['description'] !!}
@endforeach
@endif
@if(count($route['queryParameters']))
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
@foreach($route['queryParameters'] as $attribute => $parameter)
    {{$attribute}} | @if($parameter['required']) required @else optional @endif | {!! $parameter['description'] !!}
@endforeach
@endif

<!-- END_{{$route['id']}} -->
