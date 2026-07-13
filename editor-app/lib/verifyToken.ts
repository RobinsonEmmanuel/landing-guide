import jwt from 'jsonwebtoken';

export type AuthPayload = {
  email: string;
  name?: string;
  iat: number;
  exp: number;
};

export function verifyToken(authorizationHeader: string | null): AuthPayload | null {
  if (!authorizationHeader?.startsWith('Bearer ')) return null;
  const token = authorizationHeader.slice(7);
  const secret = process.env.JWT_SECRET;
  if (!secret) return null;
  try {
    return jwt.verify(token, secret) as AuthPayload;
  } catch {
    return null;
  }
}
