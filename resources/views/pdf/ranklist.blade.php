<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $paper->name }}</title>
    <style>
        /** Define the margins of your page **/

        @page {
            margin: 50px 15px;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0px;
            right: 0px;
            height: 120px;
            /** Extra personal styles **/
            background-color: #004400;
            color: white;
            text-align: center;

        }

        header p {
            font-size: 25px;
            margin-top: 8px;
        }
        header span {
            font-size: 20px;

        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 35px;
            line-height: 35px;
            font-size: 15px !important;
            color: white !important;
            /** Extra personal styles **/
            background-color: rgba(1, 88, 1, 0.97);
            text-align: center;

        }

        table,
        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
        }
        th{
            background-color:yellow;
            line-height:25px;
        }
        main{
            padding-top: 100px;
        }
    </style>
</head>

<body>
    <header>
        <?php
        $count = 1;
        ?>
        <h2>Easy English</h2>
            <span style="font-size: 20px;">
            Exam Name: {{ $paper->name }} <br>
            Full Mark :{{ $paper->questions->count() * $paper->pmark }}<br>
            Total Questions : {{ $paper->questions->count() }}</span>

    </header>
    <footer>
        <div>Copyright © <?php echo date('Y'); ?> . All rights reserved.</div>
    </footer>
    <main>

        <table id="table" class="table table-striped table-bordered table-sm mt-5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Correct</th>
                    <th>Not Ans</th>
                    <th>Wrong</th>
                    <th>Attempt</th>
                    <th>Mark</th>
                    <th>Duration</th>
                    <th>Submitted</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($result as $r)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->ca }}</td>
                        <td>{{ $r->na }}</td>
                        <td>{{ $r->wa }}</td>
                        <td>{{ $r->ca + $r->wa }}</td>
                        <td>{{ $r->total_mark }}</td>
                        <td>{{ floor($r->duration / 60) }} Min
                            {{ $r->duration % 60 }} Sec</td>
                        <td>{{ date_format($r->created_at, 'd M, Y h:i a') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <span class="font-weight-300 text-success" style="font-size: 12px;"><i> (
                {{ $paper->pmark }}
                Mark for Per Correct Answer )</i></span>
        <span class="font-weight-300 text-danger" style="font-size: 12px;"><i> (
                {{ $paper->nmark }}
                Mark for Per Negative Answer )</i></span>

    </main>




</body>

</html>
