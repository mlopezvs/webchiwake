<?php

class FrontendController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function home()
	{
		return View::make('frontend.home');
	}

    public function nosotros()
    {
        return View::make('frontend.nosotros');
    }

    public function menu()
    {
        return View::make('frontend.menu');
    }

    public function reservacion()
    {
        $mensaje = null;

        return View::make('frontend.reservacion', compact('mensaje'));
    }

    public function reservacionForm()
    {
        $data = [
            'nombre' => Input::get('nombre'),
            'apellidos' => Input::get('apellidos'),
            'email' => Input::get('email'),
            'telefono' => Input::get('telefono'),
            'fecha' => Input::get('fecha'),
            'hora' => Input::get('hora'),
            'personas' => Input::get('personas'),
        ];

        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'personas' => 'required|min:1|max:100'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->passes())
        {
            $fromEmail = 'marco@minduck.com';
            $fromNombre = 'Marco Lopez';

            Mail::send('emails.frontend.reservacion', $data, function($message) use ($fromNombre, $fromEmail){
                $message->to($fromEmail, $fromNombre);
                $message->from($fromEmail, $fromNombre);
                $message->subject('Chiwake - Reservación');
            });

            $mensaje = '<div class="alert notification alert-success">Tu mensaje ha sido enviado.</div>';

            return View::make('frontend.reservacion', compact('mensaje'));
        }
        else
        {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
    }

    public function contacto()
    {
        $mensaje = null;
        return View::make('frontend.contacto', compact('mensaje'));
    }

    public function contactoForm()
    {
        $data = [
            'mensaje' => Input::get('mensaje'),
            'nombre' => Input::get('nombre'),
            'email' => Input::get('email')
        ];

        $rules = [
            'mensaje' => 'required',
            'nombre' => 'required',
            'email' => 'required|email'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->passes())
        {
            $fromEmail = 'marco@minduck.com';
            $fromNombre = 'Marco Lopez';

            Mail::send('emails.frontend.contacto', $data, function($message) use ($fromNombre, $fromEmail){
                $message->to($fromEmail, $fromNombre);
                $message->from($fromEmail, $fromNombre);
                $message->subject('Chiwake - Contacto');
            });

            $mensaje = '<div class="alert notification alert-success">Tu mensaje ha sido enviado.</div>';

            return View::make('frontend.contacto', compact('mensaje'));
        }
        else
        {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
    }

}
