<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            div {
                padding-bottom: 5px;
            }
            input {
                padding: 3px;
            }
            label{
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <form action="/" method="POST">
                    <div> <label for="agent_a"> Agent 1</label> <input type="text" name="agent_a"> </div>
                    <div> <label for="agent_b"> Agent 2</label> <input type="text" name="agent_b"> </div>
                    <input type="submit" name="match" value="match">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>

                @if(isset($matches))
                    <table style="width:100%">
                        <tr>
                            <th>Firstname</th>
                            <th>zipCode</th>
                            <th>Agent zipCode</th>
                        </tr>                      

                        @foreach ($matches as $match)

                            <tr>
                                <td> {{$match['name']}} </td>
                                <td> {{$match['zipCode']}} </td>
                                <td> {{$match['agentZipCode']}} </td>
                            </tr>

                        @endforeach
                    </table> 
                @endif

            </div>
        </div>
    </body>
</html>
