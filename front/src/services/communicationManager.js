import questions from '@/assets/questions.json';
import { useAuthStore } from '@/stores/authStore';

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
