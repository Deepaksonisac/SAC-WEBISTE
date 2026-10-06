import Image from 'next/image'
import Link from 'next/link'
import { cn } from '@/lib/utils'

export function SiteLogo({ className, imageClassName }: { className?: string; imageClassName?: string }) {
  return (
    <Link
      href="/"
      className={cn('flex items-center', className)}
      aria-label="Secure Automation Consultants home"
    >
      <Image
        src="/images/logo.png"
        alt="SAC — Secure Automation Consultants, business is people"
        width={166}
        height={68}
        priority
        className={cn('h-9 w-auto object-contain sm:h-10 dark:brightness-0 dark:invert', imageClassName)}
      />
    </Link>
  )
}
