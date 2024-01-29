<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $result->user->name }}</title>
    <style>
        /** Define tde margins of your page **/

        @page {
            margin: 50px 15px;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0px;
            right: 0px;
            height: 150px;
            /** Extra personal styles **/
            background-color: rgba(0, 68, 0, 0.93);
            color: white;
            text-align: center;


        }

        header p {
            font-size: 35px;
            margin-top: 8px;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 25px;
            font-size: 15px !important;
            color: white !important;
            /** Extra personal styles **/
            background-color: rgba(0, 68, 0, 0.93);
            text-align: center;

        }

        table,
        td,
        td {
            padding: 10px;
            width: 100%;
            border: 1px solid;
            border-collapse: collapse;
            font-size: 35px;
            line-height: 55px;
        }

        .card {
            padding: 20px;
        }

        .container {
            padding-top: 150px;
            font-size: 20px;

        }
    </style>
</head>

<body>
    <header>
        <p style="margin-top: 20px !important;font-size: 35px;line-height: 45px;"><br> Easy English <br> Result Card</p>

    </header>
    <footer>
        <div style="margin-top: 8px !important;font-size: 15px;">Copyright © <?php echo date('Y'); ?>. All rights reserved.</div>
    </footer>
    <main>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table>
                        <tr>
                            <td>Name : </td>
                            <td>{{ $result->user->name }} </td>
                        </tr>
                        <tr>
                            <td>Exam Name: </td>
                            <td>{{ $result->exam_paper->name }}</td>
                        </tr>
                        <tr>
                            <td>Full Mark :</td>
                            <td>{{ $result->exam_paper->questions->count() * $result->exam_paper->pmark }} </td>
                        </tr>
                        <tr>
                            <td>Achived Mark : </td>
                            <td>{{ $result->total_mark }} /
                                {{ $result->exam_paper->questions->count() * $result->exam_paper->pmark }} </td>
                        </tr>
                        <tr>
                            <td>Total
                                Attempt :
                            </td>
                            <td>{{ $result->ca + $result->wa }}</td>
                        </tr>
                        <tr>
                            <td>Correct Answer :</td>
                            <td>{{ $result->ca }}
                                ({{ ($result->ca * 100) / $result->exam_paper->questions->count() }}%)</td>
                        </tr>
                        <tr>
                            <td>Wrong Answer :</td>
                            <td>{{ $result->wa }} ({{ ($result->wa * 100) / $result->exam_paper->questions->count() }}%)</td>
                        </tr>
                        <tr>
                            <td>Not Answer : </td>
                            <td>{{ $result->na }} ({{ ($result->na * 100) / $result->exam_paper->questions->count() }}%)</td>
                        </tr>
                        <tr>
                            <td>Submitted : </td>
                            <td>{{ date_format($result->created_at, 'd M, Y h:i a') }}</td>
                        </tr>
                        <tr>
                            <td>Duration : </td>
                            <td>{{ floor($result->duration / 60) }} Minutes
                                {{ $result->duration % 60 }} Seconds</td>
                        </tr>
                    </table>



                    <span class="font-weight-300 text-success" style="font-size: 14px;"><i>(
                            {{ $result->exam_paper->pmark }}
                            Mark for Per Correct Answer )</i></span>
                    <span class="font-weight-300 text-danger" style="font-size: 14px;"><i>(
                            {{ $result->exam_paper->nmark }}
                            Mark for Per Negative Answer )</i></span>

                </div>
            </div>

        </div>


    </main>




</body>

</html>
