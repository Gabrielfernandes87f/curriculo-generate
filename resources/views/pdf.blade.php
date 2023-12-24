<div>
    @extends('layouts.config-pdf')

    <div class="main">

        <h1> {{ $certification->name }} </h1>
        <p class="header"><a href="{{ $certification->website }}">{{ $certification->website }}</a></p>
        <p class="header">Email: {{ $certification->email }} </p>
        <p class="header">contato/whatsapp: {{ $certification->contact }} </p>
        <p class="header">Localização:{{ $certification->location }}</p>
        <p class="header"><a href="Linkedin: {{ $certification->linkedin }}">{{ $certification->linkedin }}</a></p>
    </div>
    <div class="content">

        <section class="expertise">
            Expertise:<br/>  <span>{{ $certification->expertise }}</span> 
        </section>

        <section class="sobre">
            Sobre: <br/> <span> {{ $certification->about }}</span> 
        </section>
       
        <section class="educacao">
            Educação: <br/> <span>{{ $certification->education }}</span> 
        </section>
        
        <section class="curso">
            Curso:<br/>  <span>{{ $certification->course }}</span> <br/>
             <span class="curso-link"><a href="{{ $certification->course_link }}">{{ $certification->course_link }}</a></span>
        </section>
        
        <section class="idiomas">
            Idiomas:<br/>  <span>{{ $certification->languages }}</span>  
        </section>
       
        <section class="idiomas">
            Competências:<br/>  <span>{{ $certification->Skills }}</span>  
        </section>
       
        <section class="projetos">
            Projetos:<br/><span>{{ $certification->project }}</span> 
            <span class="curso-link"> <a href="{{ $certification->projects_link }}">{{ $certification->projects_link }}</a></span>

        </section>

        <section class="profissional">
            Experiência profissional:
            <br/>

               @foreach ($certification->professional as $profissional)
               <span >
                
                <div class="empresa">
                    {{ $profissional->company }} - {{ $profissional->period }}
                </div>
                
                <div class="funcao">
                    {{ $profissional->function }}
                </div>
                <div class="descricao">
                    {!! nl2br(e($profissional->description)) !!}
                </div>

                <div class="tecnologias">
                    {{ $profissional->technology }}
                </div>
                <hr/>
            </span>
            
            @endforeach
        </section>
    </div>
</div>
