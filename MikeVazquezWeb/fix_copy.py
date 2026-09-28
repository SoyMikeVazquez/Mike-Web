import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Dictionary of fixes (regex search -> replacement)
fixes = {
    r'\bservicios\b': 'SERVICIOS',
    r'\bPROYECTOS\b': 'PROYECTOS',
    r'\bSoftware propio\b': 'SOFTWARE PROPIO',
    r'creación': 'creación', # Just to be sure, though it was correct in some places
    r'Creación': 'Creación',
    r'I\.A': 'IA',
    r'Últimos Proyectos': 'Últimos Proyectos',
    r'barbería': 'barbería',
    r'salón': 'salón',
    r'Automatizaciones': 'Automatizaciones',
    r'asesoría': 'asesoría',
    r'Asesorías': 'Asesorías',
    r'tecnologías': 'tecnologías',
    r'visión': 'visión',
    r'atención': 'atención',
    r'solución': 'solución',
    r'Soluciones': 'Soluciones',
    r'pasión': 'pasión',
    r'satisfacción': 'satisfacción',
    r'cómo': 'cómo',
    r'qué': 'qué',
    r'más': 'más',
    r'estás': 'estás',
    r'clic': 'clic',
    r'arrancar': 'arrancar',
    r'automatización': 'automatización',
    r'gestionar': 'gestionar',
}

# Actually, let's target specific sentences or blocks to avoid accidental replacements in code
# Or use word boundaries and case sensitivity carefully.

# Fixes for Menu (Visual Consistency)
content = content.replace('<h3 class="link-menu">servicios</h3>', '<h3 class="link-menu">SERVICIOS</h3>')
content = content.replace('<h3 class="link-menu">PROYECTOS</h3>', '<h3 class="link-menu">PROYECTOS</h3>')
content = content.replace('<h3 class="link-menu">Software propio</h3>', '<h3 class="link-menu">SOFTWARE PROPIO</h3>')

# Title and Meta
content = content.replace('Creación de apps y Web', 'Creación de Apps y Web')

# Main Texts
content = content.replace('Tu empresa necesita la I.A para avanzar', 'Tu empresa necesita la IA para avanzar')
content = content.replace('ahí es donde entran mis soluciones', 'aquí es donde entran mis soluciones')
content = content.replace('uso de la I.A', 'uso de la IA')
content = content.replace('Brindo tres soluciones con I.A', 'Brindo tres soluciones con IA')
content = content.replace('Asesorías con I.A para empresas', 'Asesoría Integral con IA para Empresas')

# Project Descriptions
content = content.replace('esencia de confianza, información y cobertura', 'esencia de confianza, información y seguridad')
content = content.replace('Maria pudo reflejar', 'María pudo reflejar')
content = content.replace('Maria tiene un salón', 'María tiene un salón')
content = content.replace('Brenda quiso darle un reflesh', 'Brenda buscó darle un refresh')
content = content.replace('Mi Conta App', 'Mi Conta App')
content = content.replace('generar folios y facturas de forma automatizada', 'generación de CFDI y facturación automatizada')

# Experience section
content = content.replace('He trabajado con más de 50 marcas, siempre trayendo lo último y lo mejor para su crecimiento', 'He colaborado con más de 50 marcas, implementando soluciones de vanguardia para potenciar su crecimiento.')

# Values section
content = content.replace('Copiar es bueno, pero innovar es mejor', 'Innovación sobre imitación')
content = content.replace('Adiós a proyectos genéricos, dile hola a los proyectos nuevos y únicos', 'Superamos lo genérico para crear proyectos disruptivos y exclusivos.')
content = content.replace('realizo trabajos con pasión, no con desesperación', 'Trabajamos con pasión y excelencia, cuidando cada detalle.')
content = content.replace('lo importante no es acabar, sino que estés satisfecho/a', 'Nuestra prioridad es tu total satisfacción con el resultado final.')

content = content.replace('Menos problemas, más cambios, más acciones.', 'Menos problemas, más soluciones efectivas.')
content = content.replace('Soy una persona de hechos y no de palabras', 'Soy una persona orientada a resultados tangibles.')
content = content.replace('estoy abierto a corregirlo de forma inmediata', 'asumo el compromiso de corregirlo de forma ágil')

content = content.replace('Me encanta la tecnología', 'Apasionado por la tecnología')
content = content.replace('Pregúntame lo que gustes sobre el mundo digital', 'Consulta cualquier inquietud sobre el entorno digital;')
content = content.replace('desarrollarte una a la medida', 'desarrollar una solución robusta a tu medida')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Copy edits and spelling corrections applied.")
