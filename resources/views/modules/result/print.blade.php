<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog Post - Start Bootstrap Template</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
      ol.xx li {
          position: relative;
        }
        ol.xx span {
          display: block;
          position: absolute;
          left: -35px;
          top: 0px;
        }
    </style>
  </head>
  <body class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="m-0">Name : {{ $questionnaire_code->user->first_name }} {{ $questionnaire_code->user->last_name }}</p>
          <p class="m-0">Code : {{ $questionnaire_code->codes }}</p>
          <p class="m-0">Questionnaire : {{ $questionnaire_code->questionnaire->title }}</p>
          <hr style="border-top: 3px solid blue;">
          <ol start="a" class="xx">
            @foreach($answers as $answer)
            <li>
              @if($answer->answer)
              @php
                $count = 0;
                $array = [
                  'a',
                  'b',
                  'c',
                  'd'
                ];
                $letter_ans = null;
              @endphp
              @foreach($answer->question->options as $key => $option)
                @if($answer->question_option_id == $option->id)
                @php
                  $letter_ans = $array[$key];
                  break;
                @endphp
                @endif
              @endforeach

              <span class="text-primary font-weight-bold">{{ $letter_ans }}</span>
              @else
              <span class="text-danger font-weight-bold">X</span>
              @endif
              {{ $answer->question->question }}
              <ol type="a">
                @foreach($answer->question->options as $option)
                <li class="{{ $option->is_correct == 1 ? 'text-success font-weight-bold' : '' }}">{{ $option->description }}</li>
                @endforeach
              </ol>
            </li>
            <hr style="border-top: 1px solid blue;">
            @endforeach
          </ol>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript">
<!--
window.print();
//-->
</script>
</html>
