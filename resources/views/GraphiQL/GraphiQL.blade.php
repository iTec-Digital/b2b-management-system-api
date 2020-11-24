<html lang="en">
<head>
    <title>GraphiQL - {{ env('APP_NAME') }}</title>
    <link href="{{ asset('/assets/css/GraphiQL/graphiql.min.css') }}" rel="stylesheet"/>
    <style>
        .form {
            font-family: Arial, serif;
            padding: 10px 15px;
            font-size: 15px;
            font-weight: bold;
            border-bottom: 1px solid #dddddd;
        }

        .form input[type="text"], .form select {
            padding: 5px 7px;
            margin-left: 5px;
            border: 1px solid #bcbcbc;
            border-radius: 3px;
            outline: 0;
        }

        .form .endpoint-input {
            width: 400px;
        }

        .form .auth-token-input {
            width: 250px;
        }

        .form select {
            width: 80px;
        }
    </style>
</head>
<body style="margin: 0;">

<div class="form">
    <h3 align="center" style="color: #3c3c3c; border-bottom: 1px solid #d7d7d7; padding-bottom: 10px;">{{ env('APP_NAME') }} - QUERY ANALYZER</h3>
    <label>
        Endpoint
        <input type="text" class="endpoint-input" placeholder="Enter your endpoint url here (CTRL + i)"
               value="{{ env('GRAPHIQL_ENDPOINT') }}"
               onkeyup="UpdateEndpoint(this.value);" onkeydown="if(event.keyCode === 13) { InitGraphiQL() }"
               autocomplete="off"/>
    </label>

    <label style="margin-left: 20px;">
        Auth Bearer Token
        <input type="text" class="auth-token-input" placeholder="Enter your auth token here (CTRL + b)"
               onkeyup="UpdateBearerToken(this.value);" onkeydown="if(event.keyCode === 13) { InitGraphiQL() }"
               autocomplete="off"/>
    </label>

    <label style="margin-left: 20px;">
        Method
        <select onchange="UpdateMethod(this.value);">
            <option value="post">POST</option>
            <option value="get">GET</option>
        </select>
    </label>
</div>

<div id="graphiql" style="height: 88vh;"></div>

<script
    src="{{ asset('/assets/js/react/react.production.min.js') }}"
></script>
<script
    src="{{ asset('/assets/js/react/react-dom.production.min.js') }}"
></script>
<script
    src="{{ asset('/assets/js/GraphiQL/graphiql.min.js') }}"
></script>

<script>
    const LS = window.localStorage;
    let GraphQLEndpoint = "<?php echo env('GRAPHIQL_ENDPOINT'); ?>",
        bearer_token = "",
        method = "post";

    const UpdateEndpoint = (endpoint) => {
        GraphQLEndpoint = endpoint;
        LS['__graphiql_last_endpoint'] = endpoint;
        InitGraphiQL();
    };

    const UpdateBearerToken = (bearerToken) => {
        bearer_token = bearerToken;
        LS['__graphiql_bearer_token'] = bearerToken;
    };

    const UpdateMethod = (m) => {
        method = m;
        InitGraphiQL();
    };


    function InitGraphiQL() {
        if(LS['__graphiql_last_endpoint'] !== '' && typeof LS['__graphiql_last_endpoint'] !==  'undefined' && LS['__graphiql_last_endpoint'] !== GraphQLEndpoint) {
            document.getElementsByClassName('endpoint-input')[0].value = LS['__graphiql_last_endpoint'];
            GraphQLEndpoint = LS['__graphiql_last_endpoint'];
        }

        if(LS['__graphiql_bearer_token'] !== '' && typeof LS['__graphiql_bearer_token'] !==  'undefined' && LS['__graphiql_bearer_token'] !== bearer_token) {
            document.getElementsByClassName('auth-token-input')[0].value = LS['__graphiql_bearer_token'];
            bearer_token = LS['__graphiql_bearer_token'];
        }

        const graphQLFetcher = graphQLParams =>
            fetch(GraphQLEndpoint, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${bearer_token}`
                },
                body: JSON.stringify(graphQLParams),
            })
                .then(response => response.json())
                .catch(() => response.text());
        ReactDOM.render(
            React.createElement(GraphiQL, {fetcher: graphQLFetcher}),
            document.getElementById('graphiql'),
        );
    }


    window.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.keyCode === 73) {
            e.preventDefault();
            let input = document.getElementsByClassName('endpoint-input')[0];
            let _tmp_value = input.value;
            input.value = null;
            input.value = _tmp_value;
            input.focus();
        }

        if (e.ctrlKey && e.keyCode === 66) {
            e.preventDefault();
            let input = document.getElementsByClassName('auth-token-input')[0];
            let _tmp_value = input.value;
            input.value = null;
            input.value = _tmp_value;
            input.focus();
        }
    });


    //Initialize app
    InitGraphiQL();
</script>
</body>
</html>
