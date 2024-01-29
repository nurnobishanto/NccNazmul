<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <title>{{ $paper->name }}</title>
    <style>
        /** Define tde margins of your page **/

        @page {
            margin: 50px 15px;
        }

        html,
        body,
        div {
            font-family: freeserif;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0px;
            right: 0px;
            height: 130px;
            /** Extra personal styles **/
            background-color: #004400;
            color: white;
            text-align: center;


        }

        footer {
            position: fixed;
            bottom: -50px;
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
            font-size:30px;
        }

        .card {
            padding: 20px;
        }

        .container {
            padding-top: 90px;
        }
    </style>

</head>

<body>
    <?php
    $count = 1;
    $total = $paper->questions->count();
    $timeMin = $paper->duration;

    ?>
    <header>

        <p style="font-size: 35px;">Easy English</p>
        <div style="text-align: center;font-size: 25px;">{{ $paper->name }}</div>
        <span style="text-align: center;font-size:20px;">
            <span class="text-dark">Time : {{ $timeMin }} Minutes.</span> |
            <span class="text-primary">Total Questions : {{ $total }} </span> |
            <span class="text-success "><strong> Total Mark : {{ $total }} X {{ $paper->pmark }} =
                    {{ $total * $paper->pmark }} </strong></span> <br>
            <span class="text-success">Postive Mark For Every Question : {{ $paper->pmark }}</span> |
            <span class="text-danger">Negative Mark For Every Question : {{ $paper->nmark }}</span><br>

        </span>
    </header>
    <footer>
        <div style="margin-top: 8px !important">Copyright © <?php echo date('Y'); ?>. All rights reserved.</div>
    </footer>
    <main>
        <div class="container">
            @foreach ($paper->questions as $question)
                <div style="border-style: solid;border-width: 1px;margin:5px;padding:10px">
                    <?php
                    $co = $question->ca;
                    ?>
                    <span style="font-size:20px;">{{ $count }}) {{ $question->name }}</span> <br>
                    {!! $question->description !!}
                    @if ($question->image)
                        <?php
                        $file = str_replace('\\', '/', $question->image);
                        //  $imgurl = ENV('APP_URL') . '/' . 'storage/' . $file;
                        $imgurl = 'uploads/' . $file;
                        $path = $imgurl;
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                        ?>
                        <div>
                            <img style="max-height: 200px;" src="{{ $base64 }}">
                        </div>
                    @endif

                    <ol style="list-style-type: upper-alpha;">
                        <li style="font-size:17px;">{{ $question->op1 }}</li>
                        <li style="font-size:17px;">{{ $question->op2 }}</li>
                        <li style="font-size:17px;"> {{ $question->op3 }}</li>
                        <li style="font-size:17px;"> {{ $question->op4 }}</li>
                    </ol>
                    <span style="font-size:18px;">Correct Answer : {{ $question->$co }}</span>
                    <br>
                    {!! $question->explain !!}

                    @if ($question->explain_img)
                        <?php
                        $file = str_replace('\\', '/', $question->explain_img);
                        //  $imgurl = ENV('APP_URL') . '/' . 'storage/' . $file;
                        $imgurl = 'uploads/' . $file;
                        $path = $imgurl;
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                        ?>
                        <div>
                            <img style="max-height: 200px;" src="{{ $base64 }}">
                        </div>
                    @endif



                </div>

                <?php $count = $count + 1; ?>
            @endforeach
        </div>











    </main>

    <!--the script-->
    <script>
        function generatePDF() {
            var specialElementHandlers = {
                '#hidden-element': function(element, renderer) {
                    return true;
                }
            };
            var doc = new jsPDF({
                orientation: 'potrait'
            }); //create jsPDF object
            doc.fromHTML(document.getElementById("contnet"), // page element which you want to print as PDF
                10,
                15, {
                    'width': 170, //set width
                    'elementHandlers': specialElementHandlers

                },
                function(a) {
                    doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
                });
        }
    </script>

</body>

</html>
