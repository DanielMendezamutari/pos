import crypto from 'node:crypto';

if (!globalThis.crypto) {
    globalThis.crypto = crypto.webcrypto;
}
if (globalThis.crypto && !globalThis.crypto.subtle && crypto.webcrypto) {
    globalThis.crypto.subtle = crypto.webcrypto.subtle;
}
