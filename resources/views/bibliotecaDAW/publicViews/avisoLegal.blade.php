@extends('layouts.app')

@section('title', 'Aviso Legal')

@section('content')
	<div class="headerContenido separador">
		<h1 class="tituloPagina">Aviso legal</h1>
		<p class="parrafoTitulo">Información jurídica y condiciones de uso de este proyecto académico de Biblioteca DAW.</p>
	</div>

	<section class="contacto separador" aria-labelledby="identificacion-sitio">
		<div class="contenedor-columnas">
			<article class="columna-izquierda">
				<h2 id="identificacion-sitio" class="tituloFormulario">1. Identificación del sitio web</h2>
				<p class="textoFormulario">
					Este sitio corresponde a un proyecto académico desarrollado en el marco del ciclo formativo de
					Desarrollo de Aplicaciones Web (DAW). Su finalidad principal es formativa y de demostración técnica.
				</p>

				<h3 class="tituloLabel">Titular del proyecto</h3>
				<p class="textoFormulario">Estudiante/desarrollador del proyecto Biblioteca DAW.</p>

				<h3 class="tituloLabel">Ámbito del sitio</h3>
				<p class="textoFormulario">
					El contenido mostrado, incluyendo catálogo, eventos, noticias y formularios, se ofrece con fines de
					aprendizaje y evaluación académica.
				</p>

				<h2 class="tituloFormulario">2. Condiciones generales de uso</h2>
				<p class="textoFormulario">
					El acceso y navegación por este sitio implican la aceptación de las presentes condiciones. El usuario
					se compromete a realizar un uso adecuado, lícito y respetuoso de los recursos disponibles.
				</p>
				<p class="textoFormulario">
					Queda prohibido el uso del sitio para actividades ilícitas, la alteración intencionada del
					funcionamiento de la plataforma o cualquier actuación que pueda perjudicar a terceros.
				</p>

				<h2 class="tituloFormulario">3. Propiedad intelectual e industrial</h2>
				<p class="textoFormulario">
					Los textos, diseños, código fuente, estructura y demás elementos del proyecto están protegidos por la
					normativa aplicable de propiedad intelectual. Su uso se limita al entorno académico salvo autorización
					expresa de su autor o titulares legítimos.
				</p>
				<p class="textoFormulario">
					Las marcas, logotipos o recursos de terceros utilizados con fines educativos pertenecen a sus
					respectivos propietarios.
				</p>
			</article>

			<article class="columna-derecha">
				<div>
					<h2 class="tituloFormulario">4. Exclusión de responsabilidad</h2>
					<p class="textoFormulario">
						Se procura mantener la información actualizada y el sistema operativo correctamente. No obstante,
						al tratarse de un entorno de práctica, pueden existir errores, interrupciones o cambios sin previo
						aviso.
					</p>
					<p class="textoFormulario">
						El titular no se hace responsable de los daños derivados del uso del sitio ni de decisiones tomadas
						a partir de su contenido.
					</p>

					<h2 class="tituloFormulario">5. Protección de datos</h2>
					<p class="textoFormulario">
						En caso de recopilarse datos personales mediante formularios, estos se tratarán únicamente para
						gestionar la finalidad indicada en cada formulario y dentro del contexto académico del proyecto.
					</p>
					<p class="textoFormulario">
						El usuario podrá solicitar la revisión, corrección o eliminación de sus datos de prueba a través
						del canal de contacto habilitado en la plataforma.
					</p>

					<h2 class="tituloFormulario">6. Uso de cookies</h2>
					<p class="textoFormulario">
						Esta aplicación puede utilizar cookies técnicas necesarias para su funcionamiento básico,
						autenticación de sesión y mejora de la experiencia de navegación.
					</p>

					<h2 class="tituloFormulario">7. Legislación aplicable y jurisdicción</h2>
					<p class="textoFormulario">
						Este aviso legal se interpreta conforme a la legislación española. Para cualquier conflicto,
						las partes se someterán a los juzgados y tribunales que resulten competentes según la normativa
						vigente.
					</p>

					<h2 class="tituloFormulario">8. Contacto</h2>
					<p class="textoFormulario">
						Para dudas relacionadas con este aviso legal o con el funcionamiento del proyecto, utiliza el
						formulario de la sección de contacto del sitio.
					</p>
				</div>
			</article>
		</div>
	</section>
@endsection
