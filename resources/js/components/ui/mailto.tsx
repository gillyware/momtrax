import { Button } from '@/components/ui/button'
import { ComponentProps } from 'react';

type MailtoProps = ComponentProps<"button"> &{
    email: string;
}

export const Mailto = ({ className, email }: MailtoProps) => {
  return (
    <a
      href={`mailto:${email}`}
      rel="nofollow"
      aria-label={`Send email ${email}`}
    >
      <Button className={className} variant="link">{email}</Button>
    </a>
  )
}
