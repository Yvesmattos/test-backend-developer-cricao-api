import axios from "axios";

const API_URL = 'http://localhost:8081/api';

export function insertPropostaBeneficiarios(data) {
    return axios.post(`${API_URL}/beneficiarios`, data)
}

export function getPropostas() {
    return axios.get(`${API_URL}/propostas`, )
}