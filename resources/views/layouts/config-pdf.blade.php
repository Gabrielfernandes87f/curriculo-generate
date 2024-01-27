<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


<style>
    body {
        font-family: Arial, sans-serif; margin: 0; padding: 0;
    }
    .main {
        text-align: center;
        position: absolute;
        top: 5%;
        left: 50%;
        transform: translate(-50%, -50%);
        line-height: .50rem; 


    }
        .main > h1 {
            font-size: 18px;
            font-weight: 700;
        }

        .content {
            margin-top: 130px
         }

         .content >  .educacao, .expertise, .profissional, .projetos, .curso, .sobre, .idiomas {
            font-weight: 500;
            font-size: 18px;
            
          }

          .content >  .educacao > span , .expertise > span, .profissional > span, .projetos > span, .curso > span, .sobre > span, .idiomas > span {
            font-size: 14px;
            font-weight: none;
          }
          .empresa {
            font-weight: 300;
          }
          .funcao {
            margin-bottom: 5px;
          }
          .curso-link {
            margin-left: 5px;
            color: blue;
          }

</style>
    </head>

    <body>
        @yield('body')
    </body>
</html>