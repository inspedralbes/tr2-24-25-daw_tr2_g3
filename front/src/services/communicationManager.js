import questions from '@/assets/questions.json';
import { useAuthStore } from '@/stores/authStore';
import LARAVEL_PORT from '../../config.js'

const Host = `http://localhost:${LARAVEL_PORT}/api`

export function getQuestions() {

  return questions
}

/*--------------------------------------------GET----------------------------------------------*/
export async function getGroupByTeacher(id) {
  const authStore = useAuthStore();
  try {
    const response = await fetch(Host + '/groups/getMyGroupsByTeacher/' + id, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'applicaction/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
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

export async function getGroup(code) {
  const authStore = useAuthStore();

  try {
    const response = await fetch(Host + '/groups/getGroup/' + code, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'applicaction/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
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

export async function logout() {
  try {
    const response = await fetch(Host + '/auth/logout');
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

export async function getUserData() {
  const authStore = useAuthStore();
  try {
    const response = await fetch(Host + '/user/profile', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
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
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

/*--------------------------------------------POST----------------------------------------------*/
export async function sendClass(json) {
  const authStore = useAuthStore();
  console.log("AAA", json);
  try {
    const response = await fetch(Host + '/groups/create', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'applicaction/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
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

export async function sendEmail(subject, message, recipientEmail) {
  const URL = Host + `/sendEmail`;

  const payload = {
    subject: subject,
    message: message,
    to: recipientEmail,
  };

  try {
    const response = await fetch(URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(payload),
    });

    if (response.ok) {
      const json = await response.json();
      console.log('Correo enviado:', json);
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function login(json) {
  console.log("AAA", json)
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

export async function updateUserData(userData) {
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + '/user/profile', {
      method: 'PUT',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body: JSON.stringify(userData)
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function changePassword(passwordData) {
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + '/user/change-password', {
      method: 'PUT',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body: JSON.stringify(passwordData)
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function initForm(group_id, form_id){
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + '/form/initForm', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body:  JSON.stringify({
        "group_id": group_id,
        "form_id": form_id
      })
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getFormData(form_id)
{
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + `/form/getForm/${form_id}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body: null
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function checkInGroup(email, group_code, form_id)
{
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + `/form/checkUserInGroup`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body:JSON.stringify({
        "email": email,
        "group_code": group_code,
        "form_id": form_id
      })
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getResultsForm(form_id, group_id)
{
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + `/form/getFormResults`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body:JSON.stringify({
        "form_id": form_id,
        "group_id": group_id,
      })
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function calculateCESC(form_id)
{
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + `/form/calculateDataCesc`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body:JSON.stringify({
        "form_id": form_id,
      })
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function submitForm(form_id, user_id, answers)
{
  try {
    const authStore = useAuthStore();
    const response = await fetch(Host + `/form/submitForm`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
      },
      body:JSON.stringify({
        "form_id": form_id,
        "user_id": user_id,
        "answers": answers
      })
    });

    if (response.ok) {
      const json = await response.json();
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}
