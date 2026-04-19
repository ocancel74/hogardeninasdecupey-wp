# Instrucciones de Deploy — Hogar de Niñas Cupey

## ¿Cómo editar el contenido del sitio?

**Toda la información del sitio está en un solo archivo:**
```
data/content.json
```
Edita ese archivo para cambiar textos, imágenes, directores, noticias, etc.
No necesitas tocar el código HTML, CSS ni JS.

---

## Configurar el formulario de contacto (EmailJS)

El formulario usa [EmailJS](https://www.emailjs.com/) — es **gratuito** para hasta 200 emails/mes.

### Pasos:

1. **Crea una cuenta** en https://www.emailjs.com/
2. **Conecta tu cuenta de email** (Gmail, Outlook, etc.) en *Email Services*
3. **Crea un template** en *Email Templates* con estos campos:
   - `{{from_name}}` — nombre del remitente
   - `{{from_email}}` — email del remitente
   - `{{subject}}` — asunto
   - `{{message}}` — mensaje
   - `{{to_email}}` — destinatario (info@hogardeninasdecupey.org)
4. Copia tus credenciales y ponlas en `data/content.json`:

```json
"emailjs": {
  "serviceId":  "service_XXXXXXX",
  "templateId": "template_XXXXXXX",
  "publicKey":  "XXXXXXXXXXXXXXXXXXXX"
}
```

---

## Agregar / reemplazar imágenes

1. Copia tus imágenes a la carpeta `assets/images/`
2. En `data/content.json`, actualiza la ruta correspondiente:

```json
"imagen": "assets/images/tu-imagen.jpg"
```

> Las imágenes que no existan simplemente no se muestran (sin error).

---

## Deploy en GitHub Pages

### Opción A — Método más simple (recomendado)

1. **Crea un repositorio** en GitHub (ej: `hogardeninasdecupey-web`)
2. **Sube todos los archivos** al repositorio:
   ```bash
   git init
   git add .
   git commit -m "Primer commit del sitio"
   git branch -M main
   git remote add origin https://github.com/TU_USUARIO/TU_REPOSITORIO.git
   git push -u origin main
   ```
3. Ve a tu repositorio en GitHub → **Settings** → **Pages**
4. En *Source*, selecciona: **Deploy from a branch**
5. Rama: `main` | Carpeta: `/ (root)`
6. Haz clic en **Save**
7. En 1-2 minutos tu sitio estará en: `https://TU_USUARIO.github.io/TU_REPOSITORIO/`

### Opción B — Con dominio personalizado

1. Sigue los pasos de la Opción A
2. En GitHub Pages → agrega tu dominio en *Custom domain*
3. En tu proveedor de dominio, crea un registro DNS tipo CNAME apuntando a `TU_USUARIO.github.io`

---

## Estructura de archivos

```
/
├── index.html              ← Página principal (no editar)
├── .nojekyll               ← Necesario para GitHub Pages
├── INSTRUCCIONES.md        ← Este archivo
├── css/
│   └── styles.css          ← Estilos (no editar salvo colores)
├── js/
│   └── app.js              ← Lógica (no editar)
├── data/
│   └── content.json        ← ✅ AQUÍ editas todo el contenido
└── assets/
    └── images/             ← Pon aquí todas las imágenes
```

---

## Cambiar los colores del sitio

En `css/styles.css`, al inicio del archivo busca `:root { ... }` y cambia:

```css
--color-primary:    #8B4A9E;   /* Morado principal */
--color-primary-dk: #6a3578;   /* Morado oscuro */
--color-gold:       #C9A84C;   /* Dorado acento */
```

---

## ¿Necesitas ayuda?

Escribe a tu desarrollador o visita:
- EmailJS: https://www.emailjs.com/docs/
- GitHub Pages: https://docs.github.com/pages
