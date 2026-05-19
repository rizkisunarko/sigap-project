// notif WA homemade
const { Client } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');

const app = express();

app.use(express.json());

app.get('/', (req, res) => {
    res.send('WhatsApp Gateway Aktif');
});

const client = new Client();

client.on('qr', (qr) => {
    console.log('Scan QR berikut:');
    qrcode.generate(qr, { small: true });
});

client.on('ready', () => {
    console.log('WhatsApp siap!');
});

client.on('authenticated', () => {
    console.log('WhatsApp berhasil login');
});

client.on('auth_failure', () => {
    console.log('Autentikasi gagal');
});

client.on('disconnected', () => {
    console.log('WhatsApp terputus');
});

client.initialize();

app.post('/send-message', async (req, res) => {

    try {

        const { number, message } = req.body;

        if (!number || !message) {
            return res.status(400).json({
                status: false,
                message: 'Number dan message wajib diisi'
            });
        }

        await client.sendMessage(
            number + '@c.us',
            message
        );

        res.json({
            status: true,
            message: 'Pesan berhasil dikirim'
        });

    } catch (error) {

        res.status(500).json({
            status: false,
            message: error.message
        });
    }
});

app.listen(8000, () => {
    console.log('Server berjalan di http://127.0.0.1:8000');
});