<div>
    @extends('layouts.config-pdf')

    <div class="main">

        <h1> {{ $certification->name }} </h1>
        <p class="header"><a href="{{ $certification->website }}">{{ $certification->website }}</a></p>
        <p class="header">Email: {{ $certification->email }} </p>
        <p class="header">contato/whatsapp: {{ $certification->contact }} </p>
        <p class="header">Localização: {{ $certification->location }}</p>
        <p class="header"><a href="Linkedin: {{ $certification->linkedin }}">{{ $certification->linkedin }}</a></p>
    </div>
    <div class="content">

        <div class="expertise">
            Expertise:<br/>  <span>{{ $certification->expertise }}</span> 
        </div>

        <div class="sobre">
            Sobre: <br/> <span> {{ $certification->about }}</span> 
        </div>
       
        <div class="educacao">
            Educação: <br/> <span>{{ $certification->education }}</span> 
        </div>
        
        <div class="curso">
            Curso:<br/>  <span>{{ $certification->course }}</span> <br/>
             <span class="curso-link"><a href="{{ $certification->course_link }}">{{ $certification->course_link }}</a></span>
        </div>
        
        <div class="idiomas">
            Idiomas:<br/>  <span>{{ $certification->languages }}</span>  
        </div>
       
        <div class="idiomas">
            Competências:<br/>  <span>{{ $certification->Skills }}</span>  
        </div>
       
        <div class="projetos">
            Projetos:<br/><span>{{ $certification->project }}</span> 
            <span class="curso-link"> <a href="{{ $certification->projects_link }}">{{ $certification->projects_link }}</a></span>

        </div>

        <div class="profissional">
            Experiência profissional:
            
            <hr/>
               @foreach ($certification->professional as $profissional)
               <span >
                
                <div class="empresa">
                    {{ $profissional->company }} - {{ $profissional->period }}
                </div>
                
                <div class="funcao">
                    {{ $profissional->function }}
                </div>
                <div class="descricao">
                    {!! nl2br(($profissional->description)) !!}
                </div>

                <div class="tecnologias">
                    <span class="empresa">
                        Tecnologias utilizadas: 
                    </span>
                     {{ $profissional->technology }}
                </div>
                @if (!$loop->last) 
                <hr/>
                  @endif
            </span>
            
            @endforeach
        </div>
    </div>
</div>