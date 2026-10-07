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
        src="/images/sac-logo.png"
        alt="SAC — business is people"
        width={1727}
        height={625}
        priority
        className={cn('h-11 w-auto object-contain sm:h-12', imageClassName)}
      />
    </Link>
  )
}
