import axios from 'axios';
const API_URL  = "http://81.251.199.219:41235/API/utilisateurs";

export function getUserApi() {
  return axios.get(API_URL)
    .then(response => response.data)
    .catch(error => {
      console.error("Error fetching data:", error);
      throw error;
    });
}

export function getUserById(id) {
  return axios.get(`${API_URL}/${id}`)
    .then(response => response.data)
    .catch(error => {
      console.error(`Error fetching user with ID ${id}:`, error);
      throw error;
    });
}

export function createUser(userData) {
  return axios.post(API_URL, userData)
    .then(response => response.data)
    .catch(error => {
      console.error("Error creating user:", error);
      throw error;
    });
}

export function updateUser(id, userData) {
  return axios.put(`${API_URL}/${id}`, userData)
    .then(response => response.data)
    .catch(error => {
      console.error(`Error updating user with ID ${id}:`, error);
      throw error;
    });
}

export function deleteUser(id) {
  return axios.delete(`${API_URL}/${id}`)
    .then(response => response.data)
    .catch(error => {
      console.error(`Error deleting user with ID ${id}:`, error);
      throw error;
    });
}
