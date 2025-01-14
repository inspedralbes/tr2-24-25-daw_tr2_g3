import questions from '@/assets/questions.json';

const Host = 'http://localhost:8000/api'

export function getQuestions() {
  return questions
}

/*--------------------------------------------GET----------------------------------------------*/
export async function getGroup(id) {
  try {
    const response = await fetch(Host + '/groups/getGroup/' + id, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getLetters() {
  try {
    const response = await fetch(Host + '/groups/getLetters');
    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getStudentsByTeacher(id) {
  try {
    const response = await fetch(Host + '/students/getStudentsByTeacher/' + id, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getStudentByID(id) {
  try {
    const response = await fetch(Host + '/students/getStudentsById/' + id, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });

    if (response.ok) {
      const data = await response.json();
      console.log("Manager", data);
      return data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

/*--------------------------------------------POST----------------------------------------------*/
export async function sendClass(json) {
  console.log("AAA", json);
  try {
    const response = await fetch(Host + '/groups/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'applicaction/json'
      },
      body: JSON.stringify(json)
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function register(json) {
  try {
    const response = await fetch(Host + '/auth/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(json)
    });

    if (response.ok) {
      const json = await response.json();
      console.log(json)
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function login(json) {
  try {
    const response = await fetch(Host + '/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(json)
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

/*--------------------------------------------FORMS API----------------------------------------------*/

// Obtener todos los formularios
export async function getAllForms() {
  try {
    const response = await fetch(`${Host}/forms/getAll`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al obtener los formularios:', error);
    return null;
  }
}

// Crear un formulario
export async function createForm(form) {
  try {
    const response = await fetch(`${Host}/forms/create`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form),
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al crear el formulario:', error);
    return null;
  }
}

// Obtener un formulario por ID
export async function getFormById(id) {
  try {
    const response = await fetch(`${Host}/forms/get/${id}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al obtener el formulario:', error);
    return null;
  }
}

// Actualizar un formulario
export async function updateForm(id, form) {
  try {
    const response = await fetch(`${Host}/forms/update/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form),
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al actualizar el formulario:', error);
    return null;
  }
}

// Eliminar un formulario
export async function deleteForm(id) {
  try {
    const response = await fetch(`${Host}/forms/delete/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al eliminar el formulario:', error);
    return null;
  }
}

/*--------------------------------------------QUESTIONS API----------------------------------------------*/

// Crear una pregunta
export async function createQuestion(question) {
  try {
    const response = await fetch(`${Host}/questions/create`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(question),
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al crear la pregunta:', error);
    return null;
  }
}

// Obtener una pregunta por ID
export async function getQuestionById(id) {
  try {
    const response = await fetch(`${Host}/questions/get/${id}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al obtener la pregunta:', error);
    return null;
  }
}

// Actualizar una pregunta
export async function updateQuestion(id, question) {
  try {
    const response = await fetch(`${Host}/questions/update/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(question),
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al actualizar la pregunta:', error);
    return null;
  }
}

// Eliminar una pregunta
export async function deleteQuestion(id) {
  try {
    const response = await fetch(`${Host}/questions/delete/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al eliminar la pregunta:', error);
    return null;
  }
}
